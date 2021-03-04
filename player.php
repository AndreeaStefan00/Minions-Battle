<?php
class player{
	public $name, $hmin, $hmax, $smin, $smax, $dmin, $dmax, $vmin, $vmax, $lmin, $lmax;
    public $health, $strength, $defense, $speed, $luck;

    public function __construct($_name, $_hmin, $_hmax, $_smin, $_smax, $_dmin, $_dmax, $_vmin, $_vmax, $_lmin, $_lmax){
    	$this->name = $_name;
        $this->hmin = $_hmin;
        $this->hmax = $_hmax;
        $this->smin = $_smin;
        $this->smax = $_smax;
        $this->dmin = $_dmin;
        $this->dmax = $_dmax;
        $this->vmin = $_vmin;
        $this->vmax = $_vmax;
        $this->lmin = $_lmin;
        $this->lmax = $_lmax;
    }
	
    public function getHealth($player) {
    	$this->health = rand($player->hmin,$player->hmax);
    	return $this->health;
    }
    
    public function getStrength($player) {
    	$this->strength = rand($player->smin,$player->smax);
    	return $this->strength;
    }
    
    public function getDefense($player) {
    	$this->defense = rand($player->dmin,$player->dmax);
    	return $this->defense;
    }
    
    public function getSpeed($player) {
    	$this->speed = rand($player->vmin,$player->vmax);
    	return $this->speed;
    }
      
	public function getLuck($player) {
		$this->luck = rand($player->lmin,$player->lmax);
		return $this->luck;
	}

}
?>