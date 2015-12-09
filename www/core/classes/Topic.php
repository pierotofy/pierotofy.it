<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 


/** Rappresenta un topic del forum. */
class Topic extends Entity{   

	const SELECT_SQL = "
			SELECT p.id, p.argument, p.user_id, p.subject, p.locked, 
				p.post_date, p.poll, p.question, p.replies, p.show_as, u.user,
				a.title as argument_title,
				NULL AS project_id
				FROM forum_posts p
				LEFT OUTER JOIN users u
				ON u.id = p.user_id
				LEFT OUTER JOIN forum_arguments a
				ON a.id = p.argument
	";
	// Nota sui campi
	// ========
	// subject = titolo del topic
	// id = id del topic
	// argument_title = titolo del forum di cui il topic fa parte
	// argument = id del forum di cui il topic fa parte

	private $poll_data; // Caching locale per i dati del sondaggio

	// @param values la lista dei campi per rappresentare un topic
	// 		oppure l'ID del topic.
	function Topic($values){
		parent::Entity($values);
	}

	public function getSelectSql(){
		return Topic::SELECT_SQL;
	}
 
	function getName(){
		return $this['subject'];
	}
	
	// @param page la pagina che si vuole visualizzare nel thread cominciato da questo topic
	//			nota che puo' anche essere una stringa segnaposto, ad esempio "#PAGE#"
	// @return l'URL da cui visualizzare questo topic
	function getUrl($page = 1){
		$subj = strtolower($this->getName());
		$subj = str_replace(" ","_",$subj);
		$subj = Text::AlphaNumericFilter($subj);
		if ($page == 1){
			return "/p/forum/$this[argument]/$this[id]-$subj/";
		}else{
			return "/p/forum/$this[argument]/$this[id]-$subj" . "_p$page/";
		}
	}
	
	function getLink(){
		return "<a href=\"".$this->getUrl()."\">" . purify($this->getName()) . "</a>";
	}

	function getCategoryLink(){
		return "<a href=\"/p/forum/$this[argument]\">$this[argument_title]</a>";
	}
	
	function getFullLink(){
			
		return $this->getLink() . " (".$this->getCategoryLink().")";
	}

	// @return true se questo topic contiene un sondaggio
	function isPoll(){
		return $this['poll'] != null;
	}

	/** @return Le informazioni del sondaggio tramite un array associativo, dove:
			"choices" => array con le scelte, dove:
					"id" => id della scelta
					"descr" => descrizione della scelta (come inserito dall'utente)
					"votes" => numero di voti per questa scelta
					"percentage" => percentuale normalizzata (0..1) in relazione al totale dei voti (4 decimali di precisione)
			"votes_count" => numero di voti totali
			"user_has_voted" => boolean se l'utente corrente ha gia' votato */
	function getPollData(){
		global $currentUser;

		// Cache
		if ($this->poll_data == null){

			$poll_info = unserialize($this->getRaw('poll'));
			$choices = array();
			$votes_count = 0;
			$user_has_voted = false;

			foreach($poll_info as $id => $value){ // id = numero, value = stringa descrivente la scelta
				$choices[] = array(
					"id" => $id,
					"descr" => $value, 
					"votes" => 0, 
					"percentage" => 0);
			}

			// Prende i voti dal database			
			$q = exequery("SELECT user_id, vote FROM forum_poll WHERE topic_id = $this[id]");
			while($values = mysqli_fetch_array($q)){
				$choices[$values['vote']]['votes']++; // perche' indice == id
				$votes_count++;

				if ($values['user_id'] == $currentUser['id']) $user_has_voted = true;
			}

			// Calcola le percentuali
			if ($votes_count > 0){
				foreach($choices as $id => &$values){
					$values['percentage'] = round((float)$values['votes'] / (float)$votes_count, 4);
				}
			}

			$this->poll_data = array("choices" => $choices,
						"votes_count" => $votes_count,
						"user_has_voted" => $user_has_voted);
		}

		return $this->poll_data;
	}

	// @param userObj oggetto User rappresentante l'utente da verificare per i permessi 
	// @return true se il topic puo' essere visto dall'utente passato come argomento
	function isViewableBy($userObj){
		$forum_info = Forum::GetForumInfo($this['argument']);
		return Forum::IsAccessGrantedTo($forum_info, $userObj);
	}

	// @return HTML contenente il form per votare in un sondaggio
	function renderPollForm(){
        $view_builder = new ViewBuilder("forum/poll_form.html");
        $view_builder->setValues(array_merge($this->getPollData(), array("topic_id" => $this['id'])));
        return $view_builder->render();
	}

	// @return HTML contenente i risultati del sondaggio
	function renderPollResults(){
        $view_builder = new ViewBuilder("forum/poll_results.html");
        $view_builder->setValues($this->getPollData());
        return $view_builder->render();
	}
        
    function getFormattedDate(){
        $dateNow = new DateTime();
        $seconds_in_a_day = 24 * 60 * 60;
        $diff = intval($dateNow->format('U')) - intval($this['post_date']);

        // se è passato più di un giorno dal post mostro il giorno ed il mese (ed eventualmente l'anno)
        if ($diff > $seconds_in_a_day){
        	$same_year = $dateNow->format("Y") == date("Y", $this['post_date']);
            return date( $same_year ? "d/m" : "d/m/y", $this['post_date']);
        }

        // altrimenti mostro l'ora
        return date("H:i", $this['post_date']);
    }
   
    function getNumberRepliesHtml(){
        return $this['replies'] . "<img src=\"/images/comment32.png\" style='width: 14px; height: 14px;'/>";
    }
  }
?>
