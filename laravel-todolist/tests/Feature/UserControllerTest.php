<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PhpParser\Node\Expr\PostDec;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
        ->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user' => "rio"
        ])->get("/login")
        ->assertRedirect("/");
    }

    public function testLoginSuccsess()
    {
        $this->post('/login', [
            "user" => "rio",
            "password" => "rahasia"
        ])->assertRedirect("/")
        ->assertSessionHas("user","rio");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "rio"
        ])->post('/login', [
            "user" => "rio",
            "password" => "rahasia"
        ])->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $this->post("/login",[])
        ->assertSeeText("User or Password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login',[
            "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or Password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "rio"
        ])->post('/logout')
        ->assertRedirect("/")
        ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
        ->assertRedirect("/");
    }
}
