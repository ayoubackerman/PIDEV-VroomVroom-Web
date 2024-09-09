<?php

namespace App;
use Psr\Log\LoggerInterface;
use Swarrot\Broker\Message;
use Swarrot\Processor\ProcessorInterface;
class MyProcessor implements ProcessorInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function process(Message $message, array $options): bool
    {
        $this->logger->info('Message received', ['body' => $message->getBody()]);

        return true;
    }
}