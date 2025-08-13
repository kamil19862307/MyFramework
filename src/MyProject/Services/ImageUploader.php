<?php

namespace MyProject\Services;


use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;

class ImageUploader
{
    private string $uploadDir;

    private array $allowedExtentions = ['png', 'jpg', 'jpeg', 'gif'];

    public function __construct(string $uploadDir)
    {
        $this->uploadDir = rtrim($uploadDir, '/') . '/';

        if (!is_dir($this->uploadDir)) {
            throw new NotFoundException('Такой дирректории не существует');
        }

        if (!is_writable($this->uploadDir)) {
            throw new ForbiddenException('Нет прав для записи в дирректорию');
        }
    }

    public function upload(array $file, string $prefix = 'avatar_image_'): string
    {
        // Если есть ошибка при загрузке, то выдаём исключение
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new InvalidArgumentException('Не могу загрузить файл, ошибка');
        }

        // Узнаём расширение файла
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];

        // Если загружаемый файл не 'png', 'jpg', 'gif', 'jpeg', то выдаём исключение
        if (!in_array($extension, $allowedExtensions)) {
            throw new InvalidArgumentException(
                'Загружать можно только изображения с расширением ' . implode(', ', $this->allowedExtentions)
            );
        }

        $fileName = uniqid($prefix, true) . '.' . $extension;

        $destination = $this->uploadDir . $fileName;

        // Если такая картринка уже есть, то выдаём исключение
        if (file_exists($destination)) {
            throw new InvalidArgumentException('Файл с таким именем уже существует');
        }

        // Если не получается загрузить картинку, то выдаём исключение
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new InvalidArgumentException('Не могу загрузить файл, что-то полшо не так');
        }

        return $fileName;
    }
}