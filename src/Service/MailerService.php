<?php


namespace App\Service;


use Psr\Log\LoggerInterface;
use Twig\Environment;

class MailerService
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * MailerService constructor.
     * @param Environment $twig
     * @param LoggerInterface $logger
     */
    public function __construct(Environment $twig, LoggerInterface $logger)
    {
        $this->twig = $twig;
        $this->logger = $logger;
    }

    /**
     * @param string $to
     * @param string $view
     * @param $context
     * @return bool
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendEmail(string $to, string $view, $context) : bool
    {
        $template = $this->twig->loadTemplate($view);

        $message = (new \Swift_Message())
            ->setFrom('snakeater95@gmail.com')
            ->setTo($to)
            ->setSubject($template->renderBlock('subject', $context))
            ->setBody($template->renderBlock('html', $context), 'text/html')
            // If you also want to include a plaintext version of the message
            ->addPart($template->renderBlock('text', $context), 'text/plain')
            ->setCharset('utf-8');
        // log de l'envoi
        $this->logger->info('Email Send : ' . $context);

        return $this->mailer->send($message);
    }
}
