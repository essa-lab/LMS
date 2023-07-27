<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function testRegister(){
        $userData = [
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>'password1!@',
            'password_confirmation'=>'password1!@'
        ];
        $response = $this->postJson('/api/register',$userData);
        $this->assertDatabaseHas('users',[
            'name'=>'test',
            'email'=>'test@test.com', 
        ]);
        
    }
    public function testRegisterEmailValidation(){
        $userData = [
            'name'=>'test',
            'email'=>'test_test.com',
            'password'=>'password1!@',
            'password_confirmation'=>'password1!@'
        ];
        $response = $this->postJson('/api/register',$userData);
        $response->assertStatus(422)->assertJsonValidationErrorFor('email');
        
    }
    public function testUserRegisterWithIncorrectCrenditials(){
        $userData = [
            'name'=>'test',
            'email'=>'test_test.com',
            'password'=>'password1!@',
            'password_confirmation'=>'miss_match_password'
        ];
        $response = $this->postJson('/api/register',$userData);
        $response->assertStatus(422)->assertJsonValidationErrors(['email','password']);
    }
    public function testRegisterPasswordValidation(){
        $userData = [
            'name'=>'test',
            'email'=>'test_test.com',
            'password'=>'password1!@',
            'password_confirmation'=>'miss_match_password'
        ];
        $response = $this->postJson('/api/register',$userData);
        $response->assertStatus(422)->assertJsonValidationErrorFor('password');
        
    }
    public function testLoginVaild(){
        $user = User::factory()->create([
            'name'=>'Issa',
            'email'=>'Issa@gmail.com',
            'password'=>bcrypt('password12!#$!'),
        ]);
        $response = $this->postJson('/api/login', [
            'email' => 'Issa@gmail.com',
            'password' => 'password12!#$!',
        ]);
        $this->assertAuthenticatedAs($user);
    }
    public function testLoginInvaild(){
        $user = User::factory()->create([
            'name'=>'Issa',
            'email'=>'Issad@gmail.com',
            'password'=>'password12!#$!',
        ]);
        $response = $this->postJson('/api/login', [
            'email' => 'Issa@gmail.com',
            'password' => 'passworaa#$!',
        ]);
        $this->assertGuest();
    }
    
}
