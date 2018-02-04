<?php

use Carbon\Carbon;
use CoasterCms\Models\Page;
use CoasterCms\Models\PageLang;
use CoasterCms\Tests\Feature\Traits\PagesTrait;
use CoasterCms\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DisplayPagesTest extends TestCase
{

	use PagesTrait;

    /** @test 
    * @codingStandardsIgnoreLine */
    function can_access_a_live_page_saved_in_the_admin()
    {
        $template = $this->createTemplateView('home');
        $p = $this->createPage('Home', [
        	'template' => $template->id,
        	'live' => 1,
        ], ['url' => 'pageurl']);

        $this->response = $this->get('pageurl');

        $this->response->assertStatus(200);
    }

    /** @test 
    * @codingStandardsIgnoreLine */
    function cannot_access_a_non_live_page_saved_in_the_admin()
    {
        $template = $this->createTemplateView('home');
        $p = $this->createPage('Home', [
        	'template' => $template->id,
        	'live' => 0,
        ]);

        $this->response = $this->get('/');

        $this->response->assertStatus(404);
    }

    /** @test 
    * @codingStandardsIgnoreLine */
    function can_access_a_page_between_two_dates()
    {
        $template = $this->createTemplateView('home');
        $p = $this->createPage('Home', [
            'template' => $template->id,
            'live' => 0,
            'live_start' => Carbon::parse('2018-05-02 09:00'),
            'live_end' => Carbon::parse('2018-05-03 12:00'),
        ], ['url' => '/']);        

        Carbon::setTestNow(Carbon::parse('2018-05-02 08:59:59'));
        $this->response = $this->get('/');

        $this->response->assertStatus(404);

        Carbon::setTestNow(Carbon::parse('2018-05-02 09:00:00'));
        $this->response = $this->get('/');

        $this->response->assertStatus(200);

        Carbon::setTestNow(Carbon::parse('2018-05-03 12:00:01'));
        $this->response = $this->get('/');

        $this->response->assertStatus(404);
    }
}