<?php namespace Selmonal\Imagemanager;

use Illuminate\Support\Facades\Validator;

class EloquentImageRepository implements ImageRepositoryInterface {

	/**
	 * Get the paginated data
	 * 
	 * @param  integer  $limit 
	 * @param  integer  $offset
	 * 
	 * @return Collection
	 */
	public function paginate( $limit, array $options = array())
	{
		$query = isset($options["query"]) ? $options["query"] : "";

		return Image::orderBy("id", "DESC")->where("caption" , "like" , "%". $query ."%")->paginate($limit);
	}

	/**
	 * Insert new image into database
	 * 
	 * @param  array $data
	 * 
	 * @return Selmonal\Imagemanager\Image      
	 */
	public function insert( $data )
	{
		$this->validate($data);

		return Image::create($data);
	}

	private function validate( $data )
	{
		$v = Validator::make($data, array(
		
			"path"      => "required",
			"caption"   => "",
			"extension" => "required"
		));

		if($v->fails()) 
			throw new \Exception("Please pass the required fields.");
	}
}