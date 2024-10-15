<?php

namespace App\Controllers;

use App\Services\DataProcessor;
use App\Storage\StorageInterface;
use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\InvalidJsonException;
use App\Exceptions\InvalidDataException;
use Exception;
use JetBrains\PhpStorm\NoReturn;

class ApiController
{
    public function __construct(
        private readonly DataProcessor $dataProcessor,
        private readonly StorageInterface $storage,
    ) {
    }

    public function handleRequest(): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=UTF-8');

        try {
            $this->validateMethod();

            $data = $this->getRequestData();

            $this->validateData($data);

            $sanitizedData = $this->dataProcessor->sanitize($data['payload']);

            $data['payload'] = $sanitizedData;

            if ($this->storage->store($data)) {
                $this->sendResponse(200, ['status' => 'Succcess']);
            } else {
                throw new Exception('Failed to save data');
            }
        } catch (MethodNotAllowedException | InvalidJsonException | InvalidDataException $e) {
            $this->sendResponse($e->getCode(), ['error' => $e->getMessage()]);
        } catch (Exception) {
            $this->sendResponse(500, ['error' => 'Internal Server Error']);
        }
    }

    /**
     * @throws MethodNotAllowedException
     */
    private function validateMethod(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new MethodNotAllowedException();
        }
    }

    /**
     * @throws InvalidJsonException
     */
    private function getRequestData(): array
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidJsonException();
        }

        return $data;
    }

    /**
     * @throws InvalidDataException
     */
    private function validateData(array $data): void
    {
        if (!$this->dataProcessor->isValid($data)) {
            throw new InvalidDataException();
        }
    }

    private function sendResponse(int $statusCode, array $body): void
    {
        http_response_code($statusCode);
        echo json_encode($body);
    }
}
