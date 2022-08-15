<?php

namespace Tests\Feature;

use App\Models\LoanApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoanApplicationControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
   public function test_a_login_customer_create_a_loan_request(){

            $this->setUpUser();

            //create loan appplication request
            $this->post('loan_application/create',[
                'loan_type' => 'Home',
                'loan_amount' => 10000,
                'loan_term' => 3
            ]);

            //check application count
            $this->assertEquals(1,LoanApplication::count());
   }

   public function test_a_user_can_View_application(){

        $this->setUpUser();

         //create loan appplication request
         $this->post('loan_application/create',[
            'loan_type' => 'Home',
            'loan_amount' => 10000,
            'loan_term' => 3
        ]);

        //check application count
        $this->assertEquals(1,LoanApplication::count());

   }
}
