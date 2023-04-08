<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
//use App\Repositories\CoreRepository;
//use Prettus\Repository\Eloquent\BaseRepository as CoreRepository;

use Illuminate\Container\Container as Application;
use App\Exceptions\RepositoryException;

class BaseRepository //extends CoreRepository
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;

    public function __construct()
    {
        $this->app = new Application();
        $this->makeModel();
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function get(int $modelId)
    {
        return $this->model->whereId($modelId)->first();
    }

    public function store(array $data, $model = null, $isPassword = false)
    {
        if ($model === null) {
            $model = $this->model;

            if ($isPassword) {
                $model->password = Hash::make(config('constants.DEFAULT_PASSWORD'));
                unset($data['password']);
            }
        }
        $modelFill = $model->getFillable();

        $modelData = array_filter(
            $data,
            function ($key) use ($modelFill) {
                return in_array($key, $modelFill) >= 0;
            },
            ARRAY_FILTER_USE_KEY
        );
        $model->fill($modelData);
        $model->save();
        return $model;
    }

    public function withFind($relations, $id)
    {
        return $this->model->with($relations)->find($id);
    }

    public function insertData(array $data)
    {
        return $this->model->insert($data);
    }

    public function updateData(array $data, $id)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function findWhereNotNull(string $column)
    {
        return $this->model->whereNotNull($column)->get();
    }

    public function getQueryBuilder(?string $search, string $sortOn, string $sortOrder)
    {
        $queryBuilder = $this->model->when($search !== null, function ($query1) use($search) {
                                    $query1->where( function($query2) use($search) {
                                        foreach ($this->model::SEARCH_FIELDS as $field) {
                                            $query2->orWhere($field, 'LIKE', '%' . $search . '%');
                                        }
                                    });
                                })
                                ->orderBy($sortOn, $sortOrder);
        return $queryBuilder;
    }

    public function bulkDelete(array $requestData)
    {
        $modelIds = is_array($requestData['ids']) ? $requestData['ids'] : explode(',', $requestData['ids']);
        $this->model->whereIn('id', $modelIds)->delete();
    }
}