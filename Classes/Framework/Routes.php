<?php
namespace Framework;

interface Routes
{
	public function getRoutes(): array;
	public function getAuthentication(): \Framework\Authentication;
	public function checkPermission($permission): bool;
	
}