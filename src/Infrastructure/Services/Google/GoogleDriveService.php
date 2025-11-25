<?php

namespace DevFighters\Utils\Infrastructure\Services\Google;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Exception;
use GuzzleHttp\Psr7\Response;

class GoogleDriveService
{

    private Drive $driveService;

    /**
     * @throws \Google\Exception
     */
    public function __construct(
        string                  $apiKey,
        string                  $clientId,
        string                  $clientSecret,
        string                  $authConfig,
        private readonly string $backupFolder,
        private readonly string $filesFolder,
        private readonly string $pathCache,
    )
    {

        $client = new Client();
        $client->setApplicationName('Symfony Google Drive Integration');
        $client->setScopes([Drive::DRIVE_FILE, Drive::DRIVE_METADATA_READONLY, Drive::DRIVE]);
        $client->setAuthConfig($authConfig);
        $client->setDeveloperKey($apiKey);
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);

        $this->driveService = new Drive($client);
    }

    /** @throws Exception */
    public function uploadFileToBackupFolder(
        string  $filePath,
        ?string $fileName = null,
    ): ?DriveFile
    {
        return $this->uploadFile($filePath, $fileName, $this->backupFolder);
    }

    /** @throws Exception */
    public function uploadFileToFilesFolder(
        string  $filePath,
        ?string $fileName = null,
    ): ?DriveFile
    {
        return $this->uploadFile($filePath, $fileName, $this->filesFolder);
    }

    /** @throws Exception */
    public function uploadFile(
        string  $filePath,
        ?string $fileName = null,
        ?string $folderId = null,
    ): ?DriveFile
    {
        $file = new DriveFile();
        $file->setName($fileName ?? basename($filePath));
        $file->setParents(($folderId) ? [$folderId] : null);

        $content = file_get_contents($filePath);
        $mimeType = mime_content_type($filePath);

        return $this->driveService->files->create($file, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'supportsAllDrives' => true
        ]);

    }

    /** @throws Exception */
    public function moveFile(
        string $fileId,
        string $oldParentId,
        string $newParentId,
    ): DriveFile
    {
        return $this->driveService->files->update(
            $fileId,
            new DriveFile(),
            [
                'removeParents' => $oldParentId,
                'addParents' => $newParentId,
                'supportsAllDrives' => true,
                'supportsTeamDrives' => true,
                'fields' => 'id, parents',
            ]
        );
    }

    /** @throws Exception */
    public function downloadFileById(string $fileId): string
    {
        /** @var Response $response */
        $response = $this->driveService->files->get($fileId, [
            'alt' => 'media'
        ]);
        return $response->getBody()->getContents();
    }

    /** @throws Exception */
    public function downloadBackup(string $fileId): string
    {
        /** @var Response $content */
        $content = $this->driveService->files->get($fileId, ['alt' => 'media']);
        $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('backup_', true) . '.sql.gz';
        file_put_contents($filePath, $content->getBody()->getContents());
        return $filePath;
    }

    /**
     * @return DriveFile[]
     * @throws Exception
     */
    public function listFiles(string $parentId): array
    {
        $files = [];
        $pageToken = null;

        do {
            $params = [
                'q' => sprintf("'%s' in parents and trashed = false", $parentId),
                'supportsAllDrives' => true,
                'includeItemsFromAllDrives' => true,
                'pageToken' => $pageToken,
                'fields' => 'nextPageToken, files(id, name, mimeType, parents)',
            ];

            $response = $this->driveService->files->listFiles($params);
            foreach ($response->getFiles() as $file) {
                $files[] = $file;
            }
            $pageToken = $response->getNextPageToken();
        } while ($pageToken !== null);

        return $files;
    }

    /** @throws Exception */
    public function listBackups(string $folderId): array
    {
        $files = $this->driveService->files->listFiles([
            'q' => "'$folderId' in parents",
            'orderBy' => 'createdTime desc',
            'fields' => 'nextPageToken, files(id, name, parents)',
            'includeItemsFromAllDrives' => true,
            'supportsAllDrives' => true,
        ]);
        $backups = [];
        foreach ($files->getFiles() as $file) {
            $backups[] = [
                'id' => $file->getId(),
                'name' => $file->getName(),
                'folder' => $file->getParents()
            ];
        }
        return $backups;
    }

    public function getPathCache(?string $file = null): string
    {
        return $this->pathCache . $file;
    }

}