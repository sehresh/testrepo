<?php
/*
 * SwaggerPetstoreLib
 *
 * This file was automatically generated by APIMATIC v2.0 ( https://apimatic.io ).
 */

namespace SwaggerPetstoreLib\Models;

use JsonSerializable;

/**
 * @todo Write general description for this model
 */
class Pet implements JsonSerializable
{
    /**
     * @todo Write general description for this property
     * @var integer|null $id public property
     */
    public $id;

    /**
     * @todo Write general description for this property
     * @var \SwaggerPetstoreLib\Models\Category|null $category public property
     */
    public $category;

    /**
     * @todo Write general description for this property
     * @required
     * @var string $name public property
     */
    public $name;

    /**
     * @todo Write general description for this property
     * @required
     * @var array $photoUrls public property
     */
    public $photoUrls;

    /**
     * @todo Write general description for this property
     * @var \SwaggerPetstoreLib\Models\Tag[]|null $tags public property
     */
    public $tags;

    /**
     * pet status in the store
     * @var string|null $status public property
     */
    public $status;

    /**
     * Constructor to set initial or default values of member properties
     * @param integer  $id        Initialization value for $this->id
     * @param Category $category  Initialization value for $this->category
     * @param string   $name      Initialization value for $this->name
     * @param array    $photoUrls Initialization value for $this->photoUrls
     * @param array    $tags      Initialization value for $this->tags
     * @param string   $status    Initialization value for $this->status
     */
    public function __construct()
    {
        if (6 == func_num_args()) {
            $this->id        = func_get_arg(0);
            $this->category  = func_get_arg(1);
            $this->name      = func_get_arg(2);
            $this->photoUrls = func_get_arg(3);
            $this->tags      = func_get_arg(4);
            $this->status    = func_get_arg(5);
        }
    }


    /**
     * Encode this object to JSON
     */
    public function jsonSerialize()
    {
        $json = array();
        $json['id']        = $this->id;
        $json['category']  = $this->category;
        $json['name']      = $this->name;
        $json['photoUrls'] = $this->photoUrls;
        $json['tags']      = $this->tags;
        $json['status']    = $this->status;

        return $json;
    }
}
