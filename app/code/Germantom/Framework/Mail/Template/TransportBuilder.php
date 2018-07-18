<?php

namespace Germantom\Framework\Mail\Template;
/**
* this class extends core class from magento and add a pulic function to add an attachment to email
*/
class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
    /**
     * Creates a Zend_Mime_Part attachment and attaches it to the current message scope.
     * Attachment is automatically added to the mail object after creation.
     *
     * @param  string $body
     * @param  string $mimeType
     * @param  string $disposition
     * @param  string $encoding
     * @param  string $filename A filename for the attachment
     * @return $this
     */
    public function addAttachment(
        $body,
        $mimeType = \Zend_Mime::TYPE_OCTETSTREAM,
        $disposition = \Zend_Mime::DISPOSITION_ATTACHMENT,
        $encoding = \Zend_Mime::ENCODING_BASE64,
        $filename = null
    ) {
        $this->message->createAttachment($body, $mimeType, $disposition, $encoding, $filename);
        return $this;
    }
}
