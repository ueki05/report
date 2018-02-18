<?php

/**
 * BaseReport
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property string $body
 * @property boolean $is_sent
 * @property User $User
 * 
 * @method integer getUserId()  Returns the current record's "user_id" value
 * @method string  getBody()    Returns the current record's "body" value
 * @method boolean getIsSent()  Returns the current record's "is_sent" value
 * @method User    getUser()    Returns the current record's "User" value
 * @method Report  setUserId()  Sets the current record's "user_id" value
 * @method Report  setBody()    Sets the current record's "body" value
 * @method Report  setIsSent()  Sets the current record's "is_sent" value
 * @method Report  setUser()    Sets the current record's "User" value
 * 
 * @package    report
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseReport extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('report');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('body', 'string', 2048, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 2048,
             ));
        $this->hasColumn('is_sent', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}