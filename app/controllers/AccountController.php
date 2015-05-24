<?php

class AccountController extends BaseController {


	public function getLogin()
	{
		if(Auth::check()){
			return Redirect::to('/');
		}

		return View::make('account.login');
	}

	public function postLogin()
	{
		if (!Auth::attempt(Input::only('email', 'password')))
		{
		    return Redirect::back()
		        ->withInput()
		        ->with('warning', 'Invalid Credentials');
		}

		return Redirect::intended('/');

	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('/');
	}

	public function getIndex()
	{
		return View::make('account.index')
			->with('user', Auth::user());
	}

	public function postIndex()
	{
		$user = Auth::user();

		$validator = User::validator(Input::all(), $user->id);

		if($validator->fails()){

		    return Redirect::back()
		        ->withInput()
		        ->withErrors($validator->errors());
		}

		$user->update(Input::all());

		return Redirect::back()
		    ->with('success', 'Account updated');


	}

}