<?php

foreach(Permission::with('roles')->get() as $r){

	l($r->toArray());
}

?>
