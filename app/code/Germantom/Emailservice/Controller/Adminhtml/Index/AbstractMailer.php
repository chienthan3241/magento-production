<?php

namespace Germantom\Emailservice\Controller\Adminhtml\Index;

use PHPMailer\PHPMailer\PHPMailer;
use Magento\Backend\App\Action;

/**
* This mailer class is parent class, it should not be used directly but some other class will be inherited from it
*/
class AbstractMailer extends Action 
{
	protected $_resources;
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Germantom_Emailservice::emailservice');
    }

    /**
     * return email template to customer
     * @param $template
     * @return string
     */
	protected function getEmailConfirmTemplate($firstName, $lastName) {
        $message = '<html><body>';
        $message .= '<img src="cid:logo" height="14" width="120"/> <span style="color:#42a5f5 font-size:8px">&#8226;Stolzenbergstr. 13 &#8226;D-76532 Banden-Baden</span>';
        $message .= '<hr>';
        $message .= '<br>';
        $message .= '<br>';
        $message .= '<h3>EINGANGSBEST&Auml;TIGUNG KUNDENSERVICE</h3>';
        $message .= '<br>';
        $message .= '<br>';
        $message .= 'Sehr geehrte(r) Frau/Herr ' . $firstName . ' ' . $lastName . ',';
        $message .= '<br>';
        $message .= '<br>';

        $message .= 'vielen Dank f&uuml;r Ihre Anfrage bei GEMANTOM.com. Wir haben Ihre Anliegen erhalten und werden es f&uuml;r Sie bearbeiten.';
        $message .= '<br>';
        $message .= 'Sobald wir eine L&ouml;sung f&uuml;r Sie haben, werden wir Sie kontakttieren.';

        $message .= '<br>';
        $message .= '<br>';

        $message .= 'F&uuml;r weitere Fragen stehen wir Ihnen weiterhin zur Verf&uuml;gung.';

        $message .= '<br>';
        $message .= '<br>';
        $message .= '<br>';
        $message .= '<h3>Ihr GERMANTOM-TEAM</h3>';

        $message .= "</body></html>";
                
		return $message;
	}

	/**
     * return email template to customer
     * @param $template
     * @return string
     */
	protected function getEmailReplyTemplate($firstName, $lastName, $replyMessage, $date) {
        $message = '<html><body>';
        $message .= '<img src="cid:logo" height="14" width="120"/> <span style="color:#42a5f5 font-size:8px">&#8226;Stolzenbergstr. 13 &#8226;D-76532 Banden-Baden</span>';
        $message .= '<hr>';
        $message .= '<br>';
        $message .= '<br>';

        $message .= $replyMessage;

        $message .= "</body></html>";
                
		return $message;
	}

	/**
     * send email use PHPmailer
     * @param $from
     * @param $to
     * @param $subject
     * @param $body
     * @param bool $isHtml
     * @param array $attachment
     * @param bool $smtpConfig
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    protected function sendMail($from, $to, $subject, $body, $isHtml = true, $attachment = array(), $smtpConfig = false) {
        $mail = new PHPMailer;
        $mail->setFrom($from);
        $mail->addReplyTo($from);
        $to = !is_array($to) ? [$to] : $to;
        foreach ($to as $_to) {
            $mail->addAddress($_to);
        }
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML($isHtml);
        $mail->CharSet="utf-8";
        $mail->AddEmbeddedImage(__DIR__ . '/img/logo.png', 'logo');
        if (!empty($attachment)) {
            foreach ($attachment as $_attachement) {
                $mail->addAttachment(__DIR__ . '/attachment/' . $_attachement);
            }
        }
        if ($smtpConfig !== false) {
            $mail->isSMTP();
            $mail->Host = $smtpConfig['host'];
            if ($smtpConfig['smtpAuth'] === true) {
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = $smtpConfig['username']; // SMTP username
                $mail->Password = $smtpConfig['password'];
            }
            $mail->SMTPSecure = $smtpConfig['smtpSecure'];
            $mail->Port = $smtpConfig['port'];
        }
        return $mail->send();
    }

    public function execute()
    {}
}