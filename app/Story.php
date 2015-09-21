<?php

namespace PlayableStories;

use Illuminate\Database\Eloquent\Model;

class Story extends Model {

	protected $table = 'stories';
	public $timestamps = true;

	public function slides()
	{
		return $this->hasMany('PlayableStories\Slide');
	}

	public function meters()
	{
		return $this->hasMany('PlayableStories\Meter');
	}

	public function introductions()
	{
		return $this->hasMany('PlayableStories\Introduction');
	}

}