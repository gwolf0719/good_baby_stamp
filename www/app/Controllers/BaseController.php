<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


use App\Libraries\Input;
use App\Libraries\Api;
use App\Libraries\Page;
use App\Libraries\Report;
use App\Libraries\Arr;

use App\Models\ModDB;
use App\Models\UsersModel;
use App\Models\BabysModel;
use App\Models\CardModel;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        date_default_timezone_set('Asia/Taipei');
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->input = new Input();
		$this->api = new Api();
		$this->page = new Page();
        $this->report = new Report() ;
		$this->arr = new Arr();

		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();


        $this->users = new UsersModel();
        $this->babys = new BabysModel();
        $this->moddb = new ModDB();
        $this->cards = new CardModel();
        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
}
