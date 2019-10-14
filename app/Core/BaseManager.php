<?php namespace App\Core;

use App\Exceptions\DataException;
use CodeIgniter\Entity;
use CodeIgniter\Model;

/**
 * Class BaseManager
 *
 * Provides common tools for working with our data structure.
 * Acts similar to a Repository.
 *
 * @package App\Core
 */
class BaseManager
{
    /**
     * The base model this manager works with.
     * MUST be set by extending class.
     *
     * @var Model
     */
    protected $model;

    /**
     * Holds the class properties and their default values
     * that should be used when creating a new record.
     *
     * @var array
     */
    protected $columns = [];

    /**
     * The object type (i.e. "User") that will
     * be displayed in generated error messages.
     *
     * @var string
     */
    protected $objectType = 'Thing';

    /**
     * If true, will automatically populate
     * a "selector" field with a unique hash
     * upon save or update.
     *
     * @var bool
     */
    protected $useSelectors = false;

    /**
     * @var array|null
     */
    protected $afterFind;

    public function __construct()
    {
        helper('text');
        $this->populateColumns();
    }

    /**
     * Returnes all records.
     *
     * @return array|null
     */
    public function all()
    {
        return $this->model->findAll();
    }

    /**
     * Attempts to find a single record by primary key.
     *
     * @param int $id
     *
     * @return array|object|null
     * @throws DataException
     */
    public function find(int $id)
    {
        $row = $this->model->find($id);

        if (empty($row))
        {
            throw DataException::forRecordNotFound($this->objectType);
        }

        return $this->trigger('afterFind', $row);
    }

    /**
     * @param array $wheres
     *
     * @return array|null
     * @throws DataException
     */
    public function findWhere(array $wheres)
    {
        $rows = $this->model->where($wheres)->findAll();

        if (empty($rows))
        {
            throw DataException::forRecordsNotFound($this->objectType);
        }

        return $rows;
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws DataException
     */
    public function delete(int $id)
    {
        $row = $this->find($id);

        return $this->model->delete($id);
    }

    /**
     * @param string $key
     * @param null   $value
     *
     * @return BaseManager
     */
    public function set(string $key, $value = null)
    {
        if (array_key_exists($key, $this->columns))
        {
            $this->columns[$key] = $value;
        }

        return $this;
    }

    /**
     * Creates a new record based on data already
     * set in $this->columns
     *
     * @return bool|int|string
     * @throws \ReflectionException
     */
    public function create()
    {
        if ($this->model->insert(array_filter(
            $this->columns,
            function($var) {
                return $var !== null;
            }
        )))
        {
            return $this->find($this->model->getInsertID());
        }
    }

    /**
     * Updates a instance by it's ID.
     *
     * @param int $id
     *
     * @return Entity
     * @throws DataException
     * @throws \ReflectionException
     */
    public function updateById(int $id)
    {
        $record = $this->find($id);

        return $this->updateInstance($record);
    }

    /**
     * Update an entity record in the database.
     *
     * @param Entity $instance
     *
     * @return Entity
     * @throws DataException
     * @throws \ReflectionException
     */
    public function updateInstance(Entity $instance)
    {
        $instance->fill(
            array_filter(
                $this->columns,
                function($var) {
                    return $var !== null;
                }
            )
        );

        if (! $this->model->save($instance))
        {
            throw DataException::forProblemSaving($this->model->errors(true));
        }

        return $instance;
    }


    /**
     * Pass in the model that will be used by
     * the manager instance.
     *
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Returns all errors the model has registered.
     *
     * @return array|null
     */
    public function errors()
    {
        return $this->model->errors();
    }

    /**
     * Reads our columns from the model's $allowedFields property.
     */
    public function populateColumns()
    {
        if (! $this->model instanceof Model)
        {
            return;
        }

        foreach ($this->model->allowedFields as $column)
        {
            $this->columns[$column] = null;
        }
    }

    /**
     * Simple event handler for child managers
     *
     * @param string $event
     * @param null   $data
     *
     * @return |null
     */
    protected function trigger(string $event, $data = null)
    {
        if (empty($data) || empty($this->$event)) {
            return $data;
        }

        foreach ($this->$event as $method)
        {
            if (method_exists($this, $method)) {
                $data = $this->$method($data);
            }
        }

        return $data;
    }

    /**
     * Allows setting any model column through either
     * a 'setModelColumn' method call or by the column name.
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function __set($key, $value)
    {
        // If we know about this column
        // then set it's value.
        if (array_key_exists($key, $this->columns))
        {
            $this->columns[$key] = $value;

            return $this;
        }
    }

    /**
     * If the method starts with 'set', then attempt
     * to save the column behind the scenes.
     *
     * @param $method
     * @param $args
     *
     * @return BaseManager|void
     */
    public function __call($method, $args)
    {
        if (strpos($method, 'set') !== 0)
        {
            return;
        }

        $column = $this->snakeCase(substr($method, 3));

        if (array_key_exists($column, $this->columns))
        {
            $this->columns[$column] = $args[0];
        }

        return $this;
    }

    protected function snakeCase($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }


    /**
     * A helper method to allow retrieving any values
     * that have been set for creation/updating.
     *
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->columns))
        {
            return $this->columns[$key];
        }

        if (property_exists($this, $key))
        {
            return $this->$key;
        }
    }
}
