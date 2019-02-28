<?php
class FNC extends EMBLEM {
	
	var $AdminRegistro = array();
	public $Time = FALSE;
	public $WoeDateFormat = FALSE;
	private $DB = NULL;

	/**
	 * Constructor de la Clase
	 * @private
	 */
	function __construct($DataBase) 
	{
		$this->DB = $DataBase;
		
		if (!isset($_SESSION['jobs']))
			$_SESSION['jobs'] = $this->readFTP("./db/jobs.txt","JOBS");

		if (!isset($_SESSION['castles']))
			$_SESSION['castles'] = $this->readFTP("./db/castles.txt","CASTLES");

		if (!isset($_SESSION['skills']))
			$_SESSION['skills'] = $this->readFTP("./db/skills.txt","SKILLS");			
	}
    
    public function isgm()
    {
        if (isset($_SESSION['level']) && $_SESSION['level'] > 0)
            return true;
        else
            return false;
    }
    
    public function islogged()
    {
        if (isset($_SESSION['account_id']) && isset($_SESSION['userid']) && isset($_SESSION['level']))
            return true;
        else
            return false;
    }
	
	public function islocalhost()
	{
		$local = array(
			'127.0.0.1',
			'::1'
		);

		if(in_array($_SERVER['REMOTE_ADDR'], $local))
			return true;
		else
			return false;
		
	}
	
	public function isvalidurl($url)
	{
		if (filter_var($url, FILTER_VALIDATE_URL))
			return true;
		else
			return false;
	}
	
    public function redirect($dir)
    {
        echo 
        '
            <script>
                window.location.href = '.$dir.';
            </script>
        ';
    }
    
	public function readFTP($FTPACCESS, $DIR) 
	{
		$resp[] = "unknown";
		if ( !file_exists($FTPACCESS) ) 
		{
			$AuxDir = ".".$FTPACCESS;
			$FTPACCESS = $AuxDir;
			if ( !file_exists($FTPACCESS) )
				return NULL;
		}

		if (!($handle = fopen($FTPACCESS, "rt")))
			return NULL;		

		while ($line = fgets($handle, 1024)) {
			if (($line[0] == '/' && $line[1] == '/') || $line[0] == '\0' || $line[0] == '\n' || $line[0] == '\r')
				continue;

			switch ( $DIR ) {
				case "JOBS":
					$job = sscanf($line, "%s %d");
					if (isset($job[0]) && isset($job[1])) 
					{
						for($i = 1; isset($job[0][$i]); $i++)
							if ($job[0][$i] == '_') $job[0][$i] = ' ';
						$resp[$job[1]] = $job[0];
					}
					break;

				case "ITEMS":
					$item = explode(',', $line, 4);
					if (isset($item[0]) && isset($item[1]))
						$resp[$item[0]] = $item[2];
					break;

				case "CASTLES":
					$job = sscanf($line, "%d %s");
					if (isset($job[0]) && isset($job[1])) 
					{
						for($i = 1; isset($job[1][$i]); $i++)
							if ($job[1][$i] == '_') $job[1][$i] = ' ';
						$resp[$job[0]] = $job[1];
					}
					break;

				case "SKILLS":
					$skill = sscanf($line, "%d %s");

					if (isset($skill[0]) && isset($skill[1])) 
					{
						for($i = 1; isset($skill[1][$i]); $i++)
							if ($skill[1][$i] == '_') $skill[1][$i] = ' ';
						$resp[$skill[0]] = $skill[1];
					}
					break;
			}	
		}

		fclose($handle);
		return $resp;
	}
	
	/**
	 * Declaración de Parámetros importantes a usar a lo largo del programa
	 * @param string $home_dir Contiene la dirección del llamado de la carpeta
	 */
	public function getDefinedConsts($home_dir) 
	{
		$filepath = str_replace('\\', '/', $home_dir);
		$docroot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
		$filedir = str_replace($docroot, '', $filepath);
		$protocol_g = "http"; 
		$home_url = $protocol_g . $_SERVER['HTTP_HOST'] . "$filedir";
		
		defined('DS') ? null : define('DS', "/");
		defined('HOME_DIR') ? null : define('HOME_DIR', $filepath);
		defined('HOME_URL') ? null : define("HOME_URL", $home_url);	
		defined('MDIR') ? null : define('MDIR', HOME_DIR . '/modules/');
		defined('IDIR') ? null : define('IDIR', HOME_DIR . '/includes');
		defined('MURL') ? null : define('MURL', HOME_URL . '/modules/');
		defined('IURL') ? null : define('IURL', HOME_URL . '/includes');
		
		define('EAMOD', 1);
		define('RAMOD', 2);
	}
	
	public function get_emulator()
	{
		$CONFIG = new CONFIG;
		switch (strtolower($CONFIG->getConfig('Emulator')))
		{
			case 'eamod': 	return 1;
			case 'ramod': 	return 2;
			default:
				die('Emulator configuration return\'s 0 please use a valid Emulator(eamod/ramod) in config file.');
			break;
		}
	}
	
	public function get_emulator_query()
	{
		$arr = array();
		if ($this->get_emulator() == EAMOD)
			return "`level`";
		else
			return "`group_id`";
	}
	
	/**
	 * Devuelve los font-Awesomes por enums
	 * @param  enum $enum includes/enum.php
	 * @return string   Font-Awesome
	 */
	public function getFontAwesome($enum) 
	{
		switch($enum) 
		{
			case 'date': return 'fa-calendar';
			case 'string': return 'fa-font';
			case 'dropdown': return 'fa-angle-double-down';
			case 'int': return 'fa-hashtag';
			case 'readonly': return 'fa-ban';
		}
	}

	/**
	 * @return string Devuelve la fecha
	 * http://php.net/manual/en/timezones.america.php
	 */
	public function SetTime() 
	{
		$CONFIG = new CONFIG;

		date_default_timezone_set($CONFIG->getConfig('Time_Zone'));
		$date =  DateTime::createFromFormat("Y-m-d H:i:s",date("Y-m-d H:i:s"));
		if ($date->format('H') >= 12 )
			$string = "PM";
		else
			$string = "AM";
		$this->Time = $date->format('H:i') . " ". $string;
		$this->WoeDateFormat = $date;
	}
	
	public function GetTime()
	{
		if (empty($this->Time))
			$this->SetTime();
		return $this->Time;
	}

	/**
	 * @return IP Retorna el valor de IP/Proxy
	 */
	public function getIP() 
	{
		return getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');
	}

	/**
	 * Busca entre los Global Vars los valores a devolver
	 * @param  data_cell $data_cell Campo de estructura dentro de los extends de los modulos
	 * @param  Class $array     Global Var class
	 */
	public function SubCDD($data_cell, $array) 
	{
		switch ($data_cell)
		{
			case strstr($data_cell, "genero"):  return $array->Global_Genero;
			case strstr($data_cell, "sex"):  return $array->Global_Genero;
			case strstr($data_cell, "pais"): return $array->Global_pais;
			case strstr($data_cell, "class"): return $array->Global_Jobs;
			case strstr($data_cell, "mvp"): return $array->Global_MVPCard;
			case strstr($data_cell, "forum_categories"): return $array->Global_ForumCategory;
 			case strstr($data_cell, "forum_group_id"): return $array->Global_ForumGroups;   
			case  "question": return $array->Global_questions;
			default: return false;
		}
	}
	
	/**
	 * Devuelve el valor de un dropdown o array por el Index ejemplo array(1, "Esto Devolvería")
	 */
	public function GetValueFromVarIndex($data_cell, $array, $index) 
	{
		$arr = $this->SubCDD($data_cell, $array);
		return  ( isset($arr[$index][1]) ? $arr[$index][1] : "No asignado");
	}
	
	
	//create dropdown
	public function CDD($data_cell, $row, $array, $data_value )
	{
		if ( $arr = $this->SubCDD($data_cell, $array) )
		{
			$dropdown = '<select  class="form-control custom-select get_selectpicker_data"  name="'.($data_cell == "mvp" ? 'opt' : $data_cell )."".'">';
			foreach ($arr as $pocicion => $valor)				
				$dropdown .= '<option value="'.$valor[0].'"'.($row != "" ? (strtolower($row[$data_cell]) == strtolower($valor[0]) ? 'selected="selected"':'') : "").'>'.$valor[1].'</option>';
			$dropdown.= '</select>';
			return $dropdown;
		}
		return $this->C_STRING($data_cell, $row, 0, 0);
	}
		
	/**
	 * CREATE STRING
	 * @param  data_cell $data_cell nombre de columna
	 * @param  SQL_ARRAY $row       Valor de SQL
	 * @param  string $control_group titulo del contenedor de grupo
	 * @param  [[Type]] $classtoid     ADMIN_YELLOW Color de clase
	 */
	public function C_STRING($data_cell, $row, $control_group ="", $classtoid ="" )
	{
		$string = '<input data-control-group='.$control_group.' id="get-data-from-'.$classtoid.'" class="form-control" value="'.($row != "" ? $row[$data_cell] : "").'" name="'.$data_cell.'">';
		return $string;
	}

	/**
	 * CREATE INPUT
	 * @param  object $type  text password submit
	 * @param  css_style $id    
	 * @param  css_style $class 
	 * @param  form_input $name  
	 * @param  form_input $value
	 */
	public function C_INPUT($type="text", $id="", $class="", $name="", $value="", $placeholder="", $extra="") 
	{
		return '<input type="'.$type.'" id="'.$id.'" class="'.$class.'" value="'.$value.'" name="'.$name.'" placeholder="'.$placeholder.'" '.$extra.'>';
	}

	public function moneyformat($string) 
	{
		$string = trim($string);
		$return = "";
		$len = strlen($string) - 1;

		for ($i = 0; $i < strlen($string); $i++) {
			if ($i > 0 && $i % 3 == 0)
				$return = ".".$return;
			$return = $string[$len - $i].$return;
		}
		return "&pound; ".$return;
	}
	
	public function playtime($time) 
	{
		$days = intval($time / 86400);
		$time -= $days * 86400;

		$hour = intval($time / 3600);
		$time -= $hour * 3600;

		$minute = intval($time / 60);
		$time -= $minute * 60;

		$second = $time;

		$days = $days > 0 ? $days : 0;
		$hour = $hour > 0 ? $hour : 0;
		$minute = $minute > 0 ? $minute : 0;
		$second = $second > 0 ? $second : 0;

		return sprintf("%d days, %02d:%02d:%02d", $days, $hour, $minute, $second);
	}
	
	public function CheckMD5($texto) 
	{
		$CONFIG = new CONFIG;
		if ( $CONFIG->getConfig('UseMD5') != 'no' ) 
			return md5($texto);
		else
			return $texto;
	}

	public function shorter($text, $chars_limit)
	{
		if (strlen($text) > $chars_limit)
		{
			$new_text = substr($text, 0, $chars_limit);
			$new_text = trim($new_text);
			return $new_text . "...";
		}
		else
			return $text;
	}
	
	/*
     * [Oboro 3.0] Server Status
     * Could Make small DDoS or IntVal's
     * If problems return always true
     */
	public function ServerStatus() 
	{
		$CONFIG = new CONFIG;
		return (@fsockopen("udp://".$CONFIG->getConfig('DBHost'), $CONFIG->getConfig('Map'), $errCode, $errStr,1) ? 'fa-check green' : 'fa-times red');
	}
	
	/**
	 * [Oboro 3.0] Estable
	 * No hay necesidad de consultar al server
	 * Por el horario de woe, mientras esté alineado
	 */
	public function getWoeStatus()
	{
		$CONFIG = new CONFIG;
		foreach ($CONFIG->WOESCHDL as $poc => $val )
		{
			if ((strtolower($val[0]) == strtolower($this->WoeDateFormat->format('l'))))
			{
				if ($this->WoeDateFormat->format('H') >= explode(":",$val[2])[0] && $this->WoeDateFormat->format('H') < explode(":",$val[3])[0])
					return '<i class="fa fa-check green"></i>';
			}
		}
		return '<i class="fa fa-times red"></i>';
	}
	
	/**
	 * Reduce consultas
	 * @@return String 0 = User online : 1 = Server Peak
	 */
	public function getUserOnline($RetValue = 0)
	{
		$CACHE = new Cache;
		$data = $CACHE->get('OnlineCount', FALSE, 1);
		if (!$data)
		{
			$result = $this->DB->execute("SELECT COUNT(1) as `total` FROM `char` WHERE online = '1'");
			if ($result)
			{
				$row = $result->fetch();
				$CACHE->put('OnlineCount', $row['total']);
				$data = $CACHE->get('OnlineCount', FALSE, 1);
				$this->DB->free($result);
			}
		}
		
		$store_peak = $CACHE->get('OnlinePeak', FALSE, 525600);
		if (!$store_peak)
			$CACHE->put('OnlinePeak', $data);
		else
		{
			if ($data > $store_peak)
			{
				$CACHE->put('OnlinePeak', $data);
				$store_peak = $CACHE->get('OnlinePeak', FALSE, 525600);
			}
		}
		
		return (!$RetValue ? $data : $store_peak);
	}
    
    public function getOnlineForumUser($RetValue = 0)
	{
		$CACHE = new Cache;
		$data = $CACHE->get('ForumOnline', FALSE, 15);
		if (!$data)
		{
			$result = $this->DB->execute("
                SELECT 
                    `display_name`,
                    `group`.`html_start`,
                    `group`.`html_end`
                FROM 
                    `oboro_forum_user` AS `user`
                LEFT JOIN 
                    `oboro_user_groups` AS `group` ON `user`.`forum_group_id` = `group`.`user_group_id`
                WHERE 
                    `online` > (NOW() - INTERVAL 20 MINUTE)
            ", [], "Forum");
			if ($result)
			{
                $tmp = array();
                while ($row = $result->fetch())
                    array_push($tmp, $row['html_start'].$row['display_name'].$row['html_end']);
                
				$CACHE->put('ForumOnline', $tmp);
				$data = $CACHE->get('ForumOnline', FALSE, 1);
				$this->DB->free($result);
			}
		}
		return (!$RetValue ? $data : $store_peak);
	}

    public function getOnlineForumUserAtDay($RetValue = 0)
	{
		$CACHE = new Cache;
		$data = $CACHE->get('ForumOnlineAtDay', FALSE, 60);
		if (!$data)
		{
			$result = $this->DB->execute("
                SELECT 
                    `display_name`,
                    `group`.`html_start`,
                    `group`.`html_end`
                FROM 
                    `oboro_forum_user` AS `user`
                LEFT JOIN 
                    `oboro_user_groups` AS `group` ON `user`.`forum_group_id` = `group`.`user_group_id`
                WHERE 
                    `online` > (NOW() - INTERVAL 1 DAY)
            ", [], "Forum");
			if ($result)
			{
                $tmp = array();
                while ($row = $result->fetch())
                    array_push($tmp, $row['html_start'].$row['display_name'].$row['html_end']);
                
				$CACHE->put('ForumOnlineAtDay', $tmp);
				$data = $CACHE->get('ForumOnlineAtDay', FALSE, 1);
				$this->DB->free($result);
			}
		}
		return (!$RetValue ? $data : $store_peak);
	}
    
	public function GetCount($count)
	{
		if ($count == 1)
			return '<i class="fa fa-trophy" style="vertical-align:middle;"></i>';
		else
			return $count;
	}
	
	public function CreateOboroTitle($icono, $title)
	{
		echo '
			<div class="row">
				<h4 class="oboro_h4"><i class="fa '.$icono.' fa-2x" style="vertical-align: middle;"> </i> <span>'.$title.'</span></h4>
            </div>
		';
	}
	
	public function CreateOboroForm($form_type, $module)
	{
		$GV = new GVAR;
		$jobs = $_SESSION['jobs'];

		echo '
            <div class="row">
                <div class="col-4 mx-auto">
                    <div class="row">
                        <div class="col-2 nopadding">
                            Filter By:
                        </div>
                        <div class="col-10 nopadding">
                        <form id="OBORO_NORMALIZED">
                            <div class="row">
                                <div class="col-9 nopadding">

		';
		
		switch($form_type)
		{
			case 'jobs':
				echo
				'
					<select name="opt" class="custom-select" data-live-search="true" data-size="10">
						<option selected value="0">Todos...</option>
				'; 
						echo $GV->get_option_value($jobs); 
				echo '
					</select>
				';
			break;
				
			case 'castle':
				echo '
					<select name="opt" class="custom-select" data-size="10">
						<option selected value="0">Level and experience</option>
						<option value="1">Castle owners</option>
					</select>
				';
			break;
				
			case 'online':
				echo '
					<select name="opt" class="custom-select" data-size="10">
						<option selected value="0">All Online</option>
						<option value="1">Online per Guild</option>
					</select>
				';
			break;
		}
		echo '
					   	               <input type="hidden" name="rank" value="'.$module.'">
                                </div>
                                <div class="col-3 nopadding">
                                    <input type="submit" value="Search" class="btn btn-primary inline_block">
                                </div>
                            </div>
			         </form></div>
                </div>
            </div>

		';
		return 0;
	}
	
	public function CreateOboroDataTable($th = array(), $sql_result)
	{		
		$jobs = $_SESSION['jobs'];
		$count = 1;
		echo 
		'
        <div class="table-responsive">
			<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed dt-responsive" width="100%" id="OboroDT">
			<thead>
				<tr>
					<th>Place</th>
		';
		foreach($th as $val)
				echo '<th>'.$val.'</th>';
		
		echo 
		'
				</tr>
			</thead>
			<tbody>
		';
		
		while ($row = $sql_result->fetch()) 
		{
			echo 
			'
				<tr>
					<td>'.$this->GetCount($count++).'</td>
			';
			
			foreach (array_keys($th) as $poc => $val)
			{
				echo '<td>';
				switch($val)
				{
					case 'name':
						echo '<a href="?account.profile-'.$row['char_id'].'-0">'.$row['name'].'</a>';
						break;
					case 'sex':
						echo '<img src="./img/'.$row['sex'].'.gif">';
						break;
					
					case 'gname':
						echo ''. (!empty($row['gname']) ? '<a href="?rankings.guildprofile-'.$row['guild_id'].'">' . $row['gname'] . '</a>' : 'None');
						break;
					
					case 'class':
					case 'fclass':
					case 'mclass':
						echo $jobs[$row[$val]];
						break;
					
					case 'online':
						echo ''. ($row['online']?'<span class="online">Online</span>':'<span class="offline">Offline</span>');
						break;
						
					case 'emblem_data':
						echo '<img src='.$this->get_emblem($row['guild_id']).' alt="X">';
						break;
						
					case 'guild_id':
						echo '
							<a href="?rankings.guildprofile-'.$row['guild_id'].'">
								' . $row['name'] . '
							</a>
						';
						break;
						
					case 'pais':
						echo '<img src="./img/db/country_flags/'. $row['pais'] .'.png">';
						break;
						
					case 'zeny':
						echo  $this->moneyformat($row['zeny']);
						break;
						
					case 'castle_id':
						if( isset($_SESSION['castles'][$row['castle_id']]) )
							echo $_SESSION['castles'][$row['castle_id']];
						else
							echo 'No Castle data id: ' . $row['castle_id'];
						break;
						
					case 'playtime':
					case 'posesion_time':
						echo $this->playtime($row[$val]);
						break;
					
					case 'CashPoints':
						echo $this->moneyformat($row['CashPoints']);
						break;	
					default:
						echo $row[$val];
						break;
				}
			}
				echo '</td>';
		}
		echo 
		'
				</tr>
			</tbody>
			</table>
        </div>
		';
		return 0;
	}
	
	public function getBlogType($blog_id)
	{
		switch($blog_id)
		{
			case 0: return 'background-position: 0px 0px;';
			case 1: return 'background-position: 0px -84px;';
			case 2: return 'background-position: 0px -56px;';
			case 3: return 'background-position: 0px -25px;';
			
		}
	}
    
    public function getDinamicForumTree($id, $option)
    {
        $tree = 
        '
            <div class="row">
                <div class="col-lg-12">
                    <div class="menu forum-tree">
                        <div class="forum-tree-inside">
							<ul>
                            	<li><a href="?forum.cat"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
        ';
        
        $subcategory = NULL;
        switch($option)
        {
            case 'post':
                //category
                $DB = new DATABASE;
                $row = $DB->execute("SELECT `cat`.`category_id`, `cat`.category_name, `post`.`title` FROM `oboro_forum_posts` AS `post` INNER JOIN `oboro_forum_categories` AS `cat` ON `post`.category = `cat`.category_id WHERE `blog_id`=?", [$id], "Forum")->fetch();
                
                $tree .= '
                    <li><a href="?forum.cat-'.$row['category_id'].'"><i class="fa fa-folder-open-o" aria-hidden="true"></i> '.$row['category_name'].'</a></li>                 
                    <li><a href="?forum.post-'.$id.'"><i class="fa fa-newspaper-o" aria-hidden="true"></i> '.$row['title'].'</a></li>                    
                ';
            break;
                
            case 'parent': break;
            
			case 'create':
                $DB = new DATABASE;
                $row = $DB->execute("SELECT category_id, category_name FROM `oboro_forum_categories` WHERE `category_id`=?", [$id], "Forum")->fetch();
                
                $tree .= '
                    <li><a href="?forum.cat-'.$row['category_id'].'"><i class="fa fa-folder-open-o" aria-hidden="true"></i> '.$row['category_name'].'</a></li>                 
					<li><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Creating New topic</li>
                ';				
			break;
			
            default:
                $tree .= '<li><a href="?forum.cat-'.$id.'"><i class="fa fa-newspaper-o" aria-hidden="true"></i> '.$option.'</a></li>';
            break;
        }
        
        $tree .= "
        					</ul>
						</div>
                    </div>
                </div>
            </div>
        ";
        return $tree;
    }
    
	public function bbc_parce($text) 
	{
        $find = array(
       		'/\[b\](.*?)\[\/b\]/s',
            '/\[i\](.*?)\[\/i\]/s',
			'/\[s\](.*?)\[\/s\]/s',
            '~\[quote\](.*?)\[/quote\]~s',
            '/\[url\](.*?)\[\/url\]/s',
			'/\[url\=(.*?)\](.*?)\[\/url\]/s',
            '~\[img\](http://i.imgur.com/.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
			'/\[list=1\](.*?)\[\/list\]/s',
			'/\[\*\](.*)/',
			'/\[list\](.*?)\[\/list\]/s',
			'/\[center\](.*?)\[\/center\]/s',
			'/\[right\](.*?)\[\/right\]/s',
			'/\[left\](.*?)\[\/left\]/s',
			'/\[color\=(#[A-f0-9]{6}|#[A-f0-9]{3})\](.*?)\[\/color\]/s',
			'/\[size\=(.*?)\](.*?)\[\/size\]/s',
			'/\[quote\=(.*?)\](.*)\[\/quote\]/s',
        );
        $replace = array(
            '<b>$1</b>',
            '<i>$1</i>',
			'<strike>$1</strike>',
            '<pre>$1</'.'pre>',
            '<a href="$1">$1</a>',
			'<a href="$1">$2</a>',
            '<img src="$1" alt="" style="max-width: 300px;" />',
			'<ol>$1</ol>',
			'<li>$1</li>',
			'<ul>$1</ul>',
			'<div style="text-align:center;">$1</div>',
			'<div style="text-align:right;">$1</div>',
			'<div style="text-align:left;">$1</div>',
			'<font color="$1">$2</font>',
			'<span style="font-size:$1%">$2</span>',
			'<blockquote><div class="title-quote"><b>Post by: </b>$1</div>$2</blockquote>',
		);
        // Replacing the BBcodes with corresponding HTML tags
        $text = preg_replace($find,$replace,$text);

        if( preg_match('/\[quote\=(.*?)\](.*)\[\/quote\]/s', $text) )
            return $this->bbc_parce($text);
        
        return preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br\ \/>/", "$1", nl2br($text));
	}
    
    /**
     * isaac
     * hace un update a la sesión en foro cada 10 minutos
     **/
    public function updateUserForum() 
    {
        if (!isset($_COOKIE['user_loggedin']) && isset($_SESSION['account_id']))
        {
            $this->DB->execute("UPDATE `oboro_forum_user` SET `online` = NOW() WHERE `account_id`= ?", [$_SESSION['account_id']], "Forum");
            setcookie('user_loggedin', date("Y-m-d H:i:s"), time() + 600);
        }        
    }
}
?>