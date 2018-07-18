<?php
/**
 * Created by PhpStorm.
 * User: mct
 * Date: 14.06.18
 * Time: 10:20
 */

namespace Germantom\Emailservice\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) 
    {
    	$installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable('germantom_customer_service')
        )->addColumn(
            'customer_service_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'ID'
        )->addColumn(
            'gender',
            Table::TYPE_TEXT,
            255,
            [],
            'Anrede'
        )->addColumn(
            'first_name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Vorname'
        )->addColumn(
            'last_name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Nachname'
        )->addColumn(
            'street',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Strasse'
        )->addColumn(
            'street_number',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Strasse nummer'
        )->addColumn(
            'street_additional',
            Table::TYPE_TEXT,
            255,
            [],
            'Adresszusatz - Packstation'
        )->addColumn(
            'postcode',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'PLZ'
        )->addColumn(
            'city',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Stadt'
        )->addColumn(
            'country',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Land'
        )->addColumn(
            'email',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Customer Email'
        )->addColumn(
            'order_number',
            Table::TYPE_TEXT,
            255,
            [],
            'Bestellungnummer'
        )->addColumn(
            'customer_number',
            Table::TYPE_TEXT,
            255,
            [],
            'Kundennummer'
        )->addColumn(
            'message',
            Table::TYPE_TEXT,
            '2M',
            [],
            'Nachricht'
        )->addColumn(
            'status',
            Table::TYPE_BOOLEAN,
            null,
            ['unsigned' => true, 'default' => null],
            'Confirm Status'
        )->addColumn(
            'is_reply',
            Table::TYPE_BOOLEAN,
            null,
            ['nullable' => false, 'default' => 0],
            'is Reply email'
        )->addColumn(
            'reply_status',
            Table::TYPE_BOOLEAN,
            null,
            ['unsigned' => true, 'default' => null],
            'Status'
        )->addColumn(
            'related_id',
            Table::TYPE_INTEGER,
            null,
            [],
            'related id of email that we reply on'
        )->addColumn(
            'created_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['default' => Table::TIMESTAMP_INIT],
            'Created Time'
        );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();

    }

}