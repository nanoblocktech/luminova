<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Email;

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;
use \Luminova\Config\BaseConfig;

class Mailer
{
    private static ?self $instance = null;
    private PHPMailer $mailer;
    public string $Subject = '';
    public string $Body = '';
    public string $AltBody = '';

    /**
     * Mailer constructor.
     *
     * @param PHPMailer $mailer The PHPMailer instance to use.
     */
    private function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
        $this->configureMailer();
    }

    /**
     * Get the Mailer instance.
     *
     * @return self The Mailer instance.
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            $mailer = new PHPMailer(!BaseConfig::isProduction());
            self::$instance = new self($mailer);
        }
        return self::$instance;
    }

    /**
     * Add an email address to the recipient list.
     *
     * @param string $address The email address.
     * @param string $name    The recipient's name (optional).
     *
     * @return bool True if the address was added successfully, false otherwise.
     */
    public function addAddress(string $address, string $name = ''): bool
    {
        return $this->mailer->addAddress($address, $name);
    }

    /**
     * Add a reply-to address.
     *
     * @param string $address The email address.
     * @param string $name    The recipient's name (optional).
     *
     * @return bool True if the reply-to address was added successfully, false otherwise.
     */
    public function addReplyTo($address, $name = ''): bool
    {
        return $this->mailer->addReplyTo($address, $name);
    }

    /**
     * Set the email sender's address.
     *
     * @param string $address The email address.
     * @param string $name    The sender's name (optional).
     * @param bool   $auto    Whether to automatically add the sender's name (optional).
     *
     * @return bool True if the sender's address was set successfully, false otherwise.
     */
    public function setFrom(string $address, string $name = '', bool $auto = true): bool
    {
        return $this->mailer->setFrom($address, $name, $auto);
    }

    /**
     * Send the email.
     *
     * @return bool True if the email was sent successfully, false otherwise.
     */
    public function send(): bool
    {
        $this->mailer->Subject = $this->Subject;
        $this->mailer->Body = $this->Body;
        $this->mailer->AltBody = $this->AltBody;
        return $this->mailer->send();
    }

    /**
     * Configure the PHPMailer instance.
     */
    private function configureMailer(): void
    {
        $this->mailer->SMTPDebug = $this->shouldDebug() ? SMTP::DEBUG_CONNECTION : SMTP::DEBUG_OFF;
        $this->mailer->CharSet = $this->getCharset(BaseConfig::getVariables("smtp.charset"));

        if (BaseConfig::getVariables("smtp.use.credentials") == 1) {
            $this->mailer->isSMTP();
            $this->mailer->Host = BaseConfig::getVariables("smtp.host");
            $this->mailer->Port = BaseConfig::getVariables("smtp.port");

            if (BaseConfig::getVariables("smtp.use.password") == 1) {
                $this->mailer->SMTPAuth = true;
                $this->mailer->Username = BaseConfig::getVariables("smtp.username");
                $this->mailer->Password = BaseConfig::getVariables("smtp.password");
            }

            $this->mailer->SMTPSecure = $this->getEncryptionType(BaseConfig::getVariables("smtp.encryption"));
        } else {
            $this->mailer->isMail();
        }

        $this->mailer->setFrom(BaseConfig::getVariables("smtp.email.sender"), BaseConfig::getVariables("app.name"));
        $this->mailer->isHTML(true);
    }

    /**
     * Determine whether debugging is enabled.
     *
     * @return bool True if debugging is enabled, false otherwise.
     */
    private function shouldDebug(): bool
    {
        return !BaseConfig::isProduction() && BaseConfig::getVariables("smtp.debug");
    }

    /**
     * Get the encryption type.
     *
     * @param string $encryption The encryption type.
     *
     * @return int The encryption type constant.
     */
    private function getEncryptionType(string $encryption): string
    {
        $encryptionTypes = [
            "tls" => PHPMailer::ENCRYPTION_STARTTLS,
            "ssl" => PHPMailer::ENCRYPTION_SMTPS,
        ];

        return $encryptionTypes[$encryption] ?? PHPMailer::ENCRYPTION_STARTTLS;
    }

    /**
     * Get the character encoding.
     *
     * @param string $charset The character encoding.
     *
     * @return int The character encoding constant.
     */
    private function getCharset(string $charset): string
    {
        $charsetTypes = [
            "utf8" => PHPMailer::CHARSET_UTF8,
            "iso88591" => PHPMailer::CHARSET_ISO88591,
            "ascii" => PHPMailer::CHARSET_ASCII,
        ];

        return $charsetTypes[$charset] ?? PHPMailer::CHARSET_UTF8;
    }
}