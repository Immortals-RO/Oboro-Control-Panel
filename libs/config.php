<?php 
class CONFIG {
	private $CONFIG = array();

	/**
	 * Constructor de la configuración
	 * @private
	 **/
	function __construct() 
	{
        if (empty($this->CONFIG))
        {
            $this->CONFIG = array (
                // Web Configuration
                'title'				=> 'OboroRO',
                'Web'				=>	'http://localhost/Oboro-Control-Panel/',
                'DBarray'			=>	'yes',

                // Configuration Of the Game Server
                'Emulator'			=>	'eamod',

                // When Someone votes, what gives the CP?
                'OnVotePoints'		=>	'#CASHPOINTS',

                // Configuration Of MySQL RO Server
                'DBHost'			=> 	'localhost',
                'DBase'				=> 	'oboro',
                'DBUser'			=>	'root',
                'DBPswd'			=>	'password',

                // Configuration Of MySQL FORUM
                'WEBHost'			=>	'localhost',
                'WEBBase'			=>	'oboro_forum',
                'WEBUser'			=>	'root',
                'WEBPswd'			=>	'password',

                //Password Settings
                'UseMD5'			=>	'no',
                'UseSecurePass'		=>	'no',

                // Configuration Of Ports
                'Login'				=>	6900,
                'Char'				=>	6121,
                'Map'				=>	5121,

                //Some Usefull links to use
                'link_descargas'	=> '#',
                'link_guildpack'	=> '#',
                'link_svinfo'		=> '#',

                //GeoLocalización Oboro - Highly recommended for hacking
                'UseGeoLocalization'=> 'yes',

                //PayPal Configuration
                'PayPal-Email'		=> 'j-isaac10@hotmail.com',
                'PayPal-Moneda'		=> 'USD',
                'PayPal-Points'		=> '#DONAPOINTS',

                //Oboro Control Panel Revision Version
                'Oboro_Version'		=>	'2k18.beta.0.2',
                'Time_Zone'			=> 'America/Los_Angeles',

                //Forum Configuration
                'GM_Delete_Level'   => 99,

                'User_Delete_Own'   => 'yes',
                'User_Modify_Own'   => 'no',
                
                'uknown_user'       => 'Guest',
            );
        }
	}
		
	//USD		=> 	Points
	public $PayPal = array(
		array(5,	300),
		array(10,	650),
		array(15,	1350),
		array(25,	3000),
		array(50,	6000),
		array(100,	13050)
	);

	public $WOESCHDL = array(
		array('Saturday',	'2.0',	'16:00', '18:00'),
		array('Sunday',	'2.0',	'16:00', '18:00'),
		array('Sunday',	'WoE2.0',	'16:00', '18:00'),
	);

	public $VOTEPOINTS = array (
		// Vote 4 Points 
		// SOLO MODIFICAR EL ID
		// Si ocupas soporte para como saber tu link directo a votación puedes pedirlo en @OboroCP FB
		array(1,	'Top Ro Hispano',		'http://toprohispano.com/vote/index.php?id=112', 10),
		array(2,	'Ragna Top',		 	'http://ragnatop.org/index.php?a=in&u=TanisRO&sid=f7Bnjh6tfSOu4F81wrHp12A2wSAtjC4r',	10)
	);

	/**
	 * Devuelve el parametro de configuracion
	 * @private
	 */
	public function getConfig($var) 
	{ 
		return (isset($this->CONFIG[$var]) ? $this->CONFIG[$var] : 0 ); 
	}
}
?>
