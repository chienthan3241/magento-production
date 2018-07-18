<?php

namespace Germantom\Sales\Model\Order\Email;

class SenderBuilder extends \Magento\Sales\Model\Order\Email\SenderBuilder {
	/**
     * Prepare and send email message
     *
     * @return void
     */
    public function send()
    {
        $this->configureEmailTemplate();

        $this->transportBuilder->addTo(
            $this->identityContainer->getCustomerEmail(),
            $this->identityContainer->getCustomerName()
        );

        $this->transportBuilder->addAttachment(
            file_get_contents(__DIR__ . '/attachments/Widerrufsbelehrung.pdf'),
            'application/pdf',
            'attachment',
            'base64',
            'Widerrufsbelehrung.pdf'
        );

        $copyTo = $this->identityContainer->getEmailCopyTo();

        if (!empty($copyTo) && $this->identityContainer->getCopyMethod() == 'bcc') {
            foreach ($copyTo as $email) {
                $this->transportBuilder->addBcc($email);
            }
        }

        $transport = $this->transportBuilder->getTransport();
        $transport->sendMessage();
    }
}