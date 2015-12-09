<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

/** Classe per la gestione dei capitoli delle guide*/

class GuideChapter extends Entity{
  const SELECT_SQL = "SELECT c.*, u.id AS user_id
            FROM adv_chapters c
            LEFT OUTER JOIN users u
            ON u.member_id = c.author_id";

  private $guide_link;
  
  //Costruttore 
  public function GuideChapter($where, $guide_link){
    parent::Entity($where);
    $this->guide_link = $guide_link;
  }

  public function getSelectSql(){
    return self::SELECT_SQL;
  }
  
  //@return Istanza di User relativa all'autore del capitolo
  //      oppure NULL se l'autore del capitolo non esiste piu' nel database.
  public function getAuthor(){
    if ($this['user_id']){
      return new User($this['user_id']);
    }else return null;
  }

  // Istanza del prossimo capitolo (se esistente)
  // @return prossimo capitolo oppure NULL
  public function getNext(){
    $chapter = new GuideChapter("validated = 1 AND guide_id = $this[guide_id] 
                                  AND chapter = " . ($this['chapter'] + 1), $this->guide_link);
    return $chapter->exists() ? $chapter : NULL;
  }

  // Istanza del capitolo precedente (se esistente)
  // @return capitolo precedente oppure NULL
  public function getPrevious(){
    $chapter = new GuideChapter("validated = 1 AND guide_id = $this[guide_id] 
                                  AND chapter = " . ($this['chapter'] - 1), $this->guide_link);
    return $chapter->exists() ? $chapter : NULL;
  }
  
  public function getLink(){
    return $this->guide_link . "$this[chapter]-" . Text::AlphaNumericFilter($this['name'],'_') . "/"; 
  }

  public function exists(){
    return ($this['id'] != null) ? true : false;
  }

  public function getContent(){
      return CodeHighlighter::fixDeprecatedPreTags($this->getRaw('context'));
  }
}
?>