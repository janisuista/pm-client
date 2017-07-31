<?php

interface IWork
{
	public function initPDO();
	public function getAll($uid);
	public function Create($desc, $uid);
	public function Delete($id);
}