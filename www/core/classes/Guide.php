<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

/** Classe per la gestione delle guide*/

class Guide extends Entity{
  private $link, $exists;

  const SELECT_SQL = "SELECT * FROM adv_guides";
  
  //Costruttore, carica i dati dalla tabella adv_guide
  public function Guide($values){
    parent::Entity($values);
    $this->exists = ($this['id'] != null) ? true : false;
    $this->link = "/p/guide/".$this['id']."-".Text::AlphaNumericFilter($this['name'],'_')."/";
  }

  public function getSelectSql(){
    return self::SELECT_SQL;
  }
  
  //@return numero di capitoli
  public function getNumChapters(){
    return DB::Count('adv_chapters', "guide_id=$this[id] AND validated=1");
  }
  
  //@return array contente tutti i capitoli di questa guida
  public function getAllChapters(){
  	$qr = exequery(GuideChapter::SELECT_SQL . " WHERE guide_id=$this[id] AND validated=1 ORDER BY chapter ASC");
  	$chapters = array();
  	while($values = mysqli_fetch_array($qr, MYSQLI_ASSOC)){
  	  $chapters[] = new GuideChapter($values, $this->link);
    }
  	return $chapters;
  }
  
  //@return ritorna un'istanza di GuideChapter corrispondente al capitolo $num se il capitolo non esite ritorna false
  public function getChapter($num){
    validate_num($num);
    return new GuideChapter("guide_id=$this[id] AND chapter=$num", $this->link);
  }
  
  //@return id dell'autore della guida
  public function getAuthorID(){
    return $this['admin_id'];
  }
  
  //@return nome dell'autore della guida
  public function getAuthorName(){
    $user = new User($this->getAuthorID());
    return $user['username'];
  }

  public function getLink(){
    return $this->link;
  }

  public function exists(){
    return $this->exists;
  }
}
?>