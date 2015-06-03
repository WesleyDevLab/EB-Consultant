<?php

class ConsultantController extends BaseController {

	/**
	 * Display a listing of the consultant.
	 *
	 * @return Response
	 */
	public function index()
	{
		$consultants = Consultant::all();
		return View::make('consultant/list', compact('consultants'));
	}
	

	/**
	 * 投顾注册，资料修改
	 *
	 * @return Response
	 */
	public function create()
	{
		if($this->user && $this->user->loggable instanceof Consultant)
		{
			return $this->edit($this->user->loggable);
		}
		
		return View::make('consultant/edit');
	}
	

	/**
	 * Store a newly created consultant in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$consultant = new Consultant();
		
		$consultant->name = Input::get('name');
		$consultant->type = Input::get('type');
		$consultant->meta = Input::get('meta');

		$consultant->save();

		if(is_null($this->user))
		{
			$user = new User();
			$user->fill(array(
				'name'=>Input::get('name'),
				'open_id'=>Session::get('weixin.open_id')
			));
			$user->loggable()->associate($consultant);
			$user->save();
			
			if($consultant->type === '个人')
			{
				return Redirect::to('product/create');
			}
			else
			{
				return Redirect::to('product/create?category=product');
			}
			
		}
		else{
			unset($this->user->is_admin);
			$this->user->loggable()->associate($consultant)->save();
		}
		
		return Redirect::to('consultant');
	}


	/**
	 * Display the specified consultant.
	 *
	 * @param  Consultant $consultant
	 * @return Response
	 */
	public function show(Consultant $consultant)
	{
		return View::make('consultant/edit', compact('consultant'));
	}


	/**
	 * Show the form for editing the specified consultant.
	 *
	 * @param  Consultant $consultant
	 * @return Response
	 */
	public function edit(Consultant $consultant)
	{
		return View::make('consultant/edit', compact('consultant'));
	}


	/**
	 * Update the specified consultant in storage.
	 *
	 * @param  Consultant $consultant
	 * @return Response
	 */
	public function update(Consultant $consultant)
	{
		
		if(!$this->user->is_admin && $this->user->id !== $consultant->id)
		{
			throw new Exception('没有权限更新此投顾', 403);
		}
		
		$consultant->name = Input::get('name');
		$consultant->type = Input::get('type');
		$consultant->meta = Input::get('meta');

		$consultant->save();

		return Redirect::to('consultant');
		
	}


	/**
	 * Remove the specified consultant from storage.
	 *
	 * @param  Consultant $consultant
	 * @return Response
	 */
	public function destroy(Consultant $consultant)
	{
		if(!$this->user->is_admin && $this->user->id !== $consultant->id)
		{
			throw new Exception('没有权限更新此投顾', 403);
		}
		
		$consultant->delete();
		
		return Redirect::to('consultant');
	}

}
