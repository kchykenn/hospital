<?php
defined('BASEPATH') OR exit('No direct script access allowed');
var_dump(file_exists(FCPATH . 'vendor/autoload.php'));

class Province extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load any necessary models, helpers, or libraries
        // $this->load->model('ProvinceModel');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/province",
     *     summary="This will return all provinces",
     *     tags={"Province"},
     *     @OA\Response(
     *         response="200",
     *         description="List of provinces",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Province")
     *         )
     *     ),
     *     security={{"basicAuth": {}}}
     * )
     */
    public function index() {
        // Example of fetching provinces from a model
        // $data['provinces'] = $this->ProvinceModel->get_all_provinces();
        
        // Returning data as JSON for demonstration
        $data = [
            ['provcode' => '001', 'provname' => 'Province 1'],
            ['provcode' => '002', 'provname' => 'Province 2']
        ];
        
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($data));
    }

    /**
     * @OA\Post(
     *     tags={"Province"},
     *     path="/api/v1/province",
     *     security={{"basicAuth": {}}},
     *     summary="Create a new province",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Province")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Province created",
     *         @OA\JsonContent(ref="#/components/schemas/Province")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     )
     * )
     */
    public function create() {
        // Get JSON body from the raw input stream
        $input = json_decode($this->input->raw_input_stream, true);

        // Validate input
        if (isset($input['provcode']) && isset($input['provname'])) {
            // Normally you'd save the province here (using the model)
            // $this->ProvinceModel->create_province($input);

            // For now, just return a mock success response
            $response = [
                'provcode' => $input['provcode'],
                'provname' => $input['provname'],
                'message' => 'Province created successfully'
            ];

            $this->output
                 ->set_content_type('application/json')
                 ->set_status_header(201)
                 ->set_output(json_encode($response));
        } else {
            // Invalid request
            $this->output
                 ->set_content_type('application/json')
                 ->set_status_header(400)
                 ->set_output(json_encode(['error' => 'Invalid input data']));
        }
    }

    /**
     * @OA\Get(
     *     tags={"Province"},
     *     path="/api/v1/province/{provcode}",
     *     security={{"basicAuth": {}}},
     *     @OA\Parameter(
     *         name="provcode",
     *         in="path",
     *         description="PSGC Province Code",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retrieve Province",
     *         @OA\JsonContent(ref="#/components/schemas/Province")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     )
     * )
     */
    public function read($provcode) {
        // Example of fetching a province based on provcode
        // $province = $this->ProvinceModel->get_province_by_code($provcode);
        
        $province = ['provcode' => $provcode, 'provname' => 'Sample Province'];
        
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($province));
    }

    /**
     * @OA\Schema(
     *     title="Province model",
     *     description="Province model",
     *     schema="Province",
     *     @OA\Property(property="provcode", type="string", description="Province PSGC Code"), 
     *     @OA\Property(property="provname", type="string", description="Province PSGC Name"),
     *     required={"provcode", "provname"}
     * )
     */
}
