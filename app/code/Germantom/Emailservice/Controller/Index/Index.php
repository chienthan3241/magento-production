<?php
 
namespace Germantom\Emailservice\Controller\Index;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class Index
 * @package Germantom\Emailservice\Controller\Index
 */
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resources;
    /**
     * array of all template with name and post url
     * @var array
     */
    protected $templateArray = array(
        'customer_service_template' => 'support'
    );

    /**
     * array of message and type for each template
     * @var array
     */
    protected $messageArray = array(
        'customer_service_success' => array(
            'type' => 'success',
            'message' => 'Danke für Ihre Anfrage. Wir werden Ihnen bald kontaktieren.'),
        'customer_service_error' => array(
            'type' => 'error',
            'message' => 'Wir können Ihre Anfrage momentant nicht bearbeiten. Es tut uns leid.'
        )
    );

    /**
     * return base url of serve
     * @return string
     */
	protected function getBaseUrl() {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];        
		return $url;
	}

    /**
     * validate if template is allow
     * @param $template
     * @return bool
     */
	protected function validate($template) {
	    $result = false;
        if (array_key_exists($template, $this->templateArray)) {
            switch ($template) {
                case 'customer_service_template':
                    //this template required some post parameters
                    $result = isset($_POST['customer_email']) && isset($_POST['vorname']) && isset($_POST['nachname']);
                    break;
            }
        }
        return $result;
    }

    /**
     * get redirect to main page
     */
	protected function redirectToMain() {
		$url = $this->getBaseUrl();
		header("location:$url");
		die();
	}

    /**
     * get redirect to post page
     */
	protected function redirectToPost($template, $message) {

	    if ($this->messageArray[$message]['type'] === 'success') {
            $this->messageManager->addSuccessMessage($this->messageArray[$message]['message']);
        } elseif ($this->messageArray[$message]['type'] === 'error') {
            $this->messageManager->addErrorMessage($this->messageArray[$message]['message']);
        }

        $url = $this->getBaseUrl() . '/' . $this->templateArray[$template];
        header("location:$url");
        die();
	}

    /**
     * return email template to customer
     * @param $template
     * @return string
     */
	protected function getEmailTemplateReply($template) {
		$message = '';
        switch ($template) {
            case 'customer_service_template':
                $message = '<html><body>';
                $message .= '<img src="cid:logo" height="14" width="120"/> <span style="color:#42a5f5 font-size:8px">&#8226;Stolzenbergstr. 13 &#8226;D-76532 Banden-Baden</span>';
                $message .= '<hr>';
                $message .= '<br>';
                $message .= '<br>';
                $message .= '<h3>EINGANGSBEST&Auml;TIGUNG KUNDENSERVICE</h3>';
                $message .= '<br>';
                $message .= '<br>';
                $message .= 'Sehr geehrte(r) Frau/Herr ' . $_POST['vorname'] . ' ' . $_POST['nachname'] . ',';
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
                break;

            default:
                # code...
                break;
        }
		return $message;
	}

    /**
     * return email template from customer to our support
     * @param $template
     * @return string
     */
	protected function getEmailTemplate($template) {
        $message = '';
        switch ($template) {
            case 'customer_service_template':
                $message = '<html><body>';
                $message .= '<hr>';
                $message .= '<br>';
                $message .= '<h3>Kundenservice Email</h3>';
                $message .= '<br>';
                $message .= '<br>';
                $message .= '<table border="1">';
                $message .= '<tr>';
                $message .= '<td>Bestellnummer: ' . (isset($_POST['ordernr']) ? $_POST['ordernr'] : '') . '</td>';
                $message .= '<td>Kundennumer: ' . (isset($_POST['customernr']) ? $_POST['customernr'] : '') . '</td>';
                $message .= '</tr>';

                $message .= '<tr>';
                $message .= '<td>Anrede: ' . (isset($_POST['andrede']) ? $_POST['andrede'] : '') . '</td>';
                $message .= '<td>Email: ' . (isset($_POST['customer_email']) ? $_POST['customer_email'] : '') . '</td>';
                $message .= '</tr>';

                $message .= '<tr>';
                $message .= '<td>Vorname: ' . (isset($_POST['vorname']) ? $_POST['vorname'] : '') . '</td>';
                $message .= '<td>Nachname: ' . (isset($_POST['nachname']) ? $_POST['nachname'] : '') . '</td>';
                $message .= '</tr>';

                $message .= '<tr>';
                $message .= '<td>Straße: ' . (isset($_POST['street']) ? $_POST['street'] : '') . '</td>';
                $message .= '<td>Nr.: ' . (isset($_POST['streetnr']) ? $_POST['streetnr'] : '') . '</td>';
                $message .= '</tr>';

                $message .= '<tr>';
                $message .= '<td colspan="2">Adresszusatz: ' . (isset($_POST['adresszusatz']) ? $_POST['adresszusatz'] : '') . '</td>';
                $message .= '</tr>';

                $message .= '<tr>';
                $message .= '<td>PLZ: ' . (isset($_POST['plz']) ? $_POST['plz'] : '') . '</td>';
                $message .= '<td>Stadt: ' . (isset($_POST['city']) ? $_POST['city'] : '') . '</td>';
                $message .= '</tr>';

                $message .= '<tr>';
                $message .= '<td>Land: ' . (isset($_POST['country']) ? $_POST['country'] : '') . '</td>';
                $message .= '</tr>';

                $message .= '<tr>';
                $message .= '<td colspan="2">Nachricht: ' . (isset($_POST['message']) ? $_POST['message'] : '') . '</td>';

                $message .= '</table>';
                $message .= "</body></html>";
                break;

            default:
                # code for other template
                break;
        }
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

    /**
     * SMTP config from server
     * @return array
     */
    protected function getSmtpConfig() {
        return array(
            'host' => 'localhost',
            'smtpAuth' => false,
            'port' => 25
        );
    }



	public function execute()
	{
        $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
        $connection = $this->_resources->getConnection();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['template']) && $this->validate($_POST['template'])) {

			    switch ($_POST['template']) {
					case 'customer_service_template':

					    //send email to support Germantom
                        #$from = $_POST['customer_email'];
                        #$to = 'support@germantom.com';
                        #$subject = 'Germantom Kundenservice Anfrage - Kundennummer: ' . $_POST['customernr'];
                        #$body = $this->getEmailTemplate($_POST['template']);
                        #$this->sendMail($from, $to, $subject, $body);

					    //send confirmation email to customer
					    $from = 'support@germantom.com';
					    $to = $_POST['customer_email'];
					    $subject = 'Germantom Kundenservice';
					    $body = $this->getEmailTemplateReply($_POST['template']);

                        $customerServiceTable = $this->_resources->getTableName('germantom_customer_service');
                        $sql = "INSERT INTO " . $customerServiceTable . 
                                " (gender, first_name, last_name, street, street_number, street_additional, postcode, city, country, email, order_number, customer_number, message, status, is_reply, reply_status, related_id)" .
                                " VALUES (:gender, :first_name, :last_name, :street, :street_number, :street_additional, :postcode, :city, :country, :email, :order_number, :customer_number, :message, :status, :is_reply, :reply_status, :related_id)";

                        $binds = array(
                            'gender' => isset($_POST['andrede']) && !empty($_POST['andrede']) ? $_POST['andrede'] : NULL,
                            'first_name' => isset($_POST['vorname']) ? $_POST['vorname'] : NULL,
                            'last_name' => isset($_POST['nachname']) ? $_POST['nachname'] : NULL,
                            'street' => isset($_POST['street']) ? $_POST['street'] : NULL,
                            'street_number' => isset($_POST['streetnr']) ? $_POST['streetnr'] : NULL,
                            'street_additional' => isset($_POST['adresszusatz']) ? $_POST['adresszusatz'] : NULL,
                            'postcode' => isset($_POST['plz']) ? $_POST['plz'] : NULL,
                            'city' => isset($_POST['city']) ? $_POST['city'] : NULL,
                            'country' => isset($_POST['country']) ? $_POST['country']: NULL,
                            'email' => isset($_POST['customer_email']) ? $_POST['customer_email'] : NULL,
                            'order_number' => isset($_POST['ordernr']) ? $_POST['ordernr'] : NULL,
                            'customer_number' => isset($_POST['customernr']) ? $_POST['customernr'] : NULL,
                            'message' => isset($_POST['message']) ? $_POST['message'] : NULL,
                            'is_reply' => 0,
                            'reply_status' => 0, 
                            'related_id' => null
                        );

                        //send the message, check for errors
                        if (!$this->sendMail($from, $to, $subject, $body)) {
                            $binds['status'] = 0;
                            $connection->query($sql, $binds);
                            $this->redirectToPost($_POST['template'], 'customer_service_error');
                        } else {
                            $binds['status'] = 1;
                            $connection->query($sql, $binds);
                            $this->redirectToPost($_POST['template'], 'customer_service_success');
                        }                        
						break;
                        
					default:
						$this->redirectToMain();
						break;
				}
			} else {
				$this->redirectToMain();
			}
		    
		} else {
		    // GET request to this service will be redirect to main
			$this->redirectToMain();
		}
	}
}