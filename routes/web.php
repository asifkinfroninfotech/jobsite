<?php


/* ARTHA SPACE DOMAIN : MANAGEMENT */
Route::group(
  [
      'domain' => 'events.arthaglobal.test',
  ],
  function () {
      Route::get('/', 'ArthaSpaceController@login');
  }
);
    
    /**
      * Admin Related Routes @Wasim
      */ 
    Auth::routes();
    Route::get('logout', 'Auth\LoginController@logout');
    Route::get('/', 'UserController@index')->middleware('auth');
    Route::get('/home', 'UserController@index')->middleware('auth');

    // Route::get('/admin/login', 'Admin\AdminLoginController@ShowLoginForm')->name('admin.login');
    // Route::post('/admin/login', 'Admin\AdminLoginController@login')->name('admin.login.submit');
    // Route::get('/admin', 'Admin\AdminController@index')->name('admin.dashboard');
    // Route::post('/admin/logout', 'Admin\AdminLoginController@logout')->name('admin.logout');

    // Company Related Routes @Wasim 
    Route::get('company/profile/view', 'CompanyController@view')->name('company.profile.view')->middleware('auth');

    Route::group(['middleware' => 'auth', 'prefix' => 'company', 'as' => 'company.'], function() {
        /**
         * Routes are meant for view, edit and update company profile @Wasim
         */ 
        Route::get('profile/edit', 'CompanyController@edit')->name('profile.edit');
        Route::post('profile/update', 'CompanyController@update')->name('profile.update');
        
        /**
         *  Routes are meant for upload Cover image, logo image and documents @Wasim
         */
        Route::post('logoCover/image/store', 'CompanyController@coverLogoUpdate')->name('cover.logo.image.store');
        Route::post('document/store', 'CompanyController@documentUpdate')->name('document.store');
        Route::post('video/store', 'CompanyController@videoUpdate')->name('video.store');
        Route::post('gallery_image/store', 'CompanyController@galleryUpdate')->name('gallery_images.store');

        Route::post('gallery_thumbnail/store', 'CompanyController@gallerythumbnailUpdate')->name('gallery_thumbnail.store');
        
      
    });

    /**Company Related other routes by VICKY */

    Route::post('/delete-documents','CompanyController@deletedocuments');
    Route::post('/delete-gallery','CompanyController@deletegallery');
    
     /**
      *  User Related Routes @Wasim
      */ 
      Route::get('user/profile/view', 'UserController@userProfileView')->name('user.profile.view')->middleware('auth');

    Route::group(['middleware' => 'auth', 'prefix' => 'user', 'as' => 'user.'], function() {
        
        Route::get('profile/edit', 'UserController@userProfileEdit')->name('profile.edit');
        Route::post('profile/update', 'UserController@userProfileUpdate')->name('profile.update');
    });    

    Route::post('/update-user-status','UserController@updateuserstatusmessage');

/**
     *  Network Related Routes @Wasim
     */ 
        Route::group(['middleware' => 'auth'], function() {
        Route::get('network', 'NetworkController@network')->name('network');
        Route::post('network', 'NetworkController@network')->name('network.search');
//        Route::get('network/list', 'AjaxController@network')->name('network.data');
    
         Route::get('getnetworkdata', 'NetworkController@getnetworkdata');
         Route::get('getfilterdata', 'NetworkController@getfilterdata');
    });

     /**
      *  API Related Routes @Wasim
      */        
	Route::get('api/get-state-list', 'AjaxController@getStateList');
  Route::get('api/get-document-list', 'AjaxController@getDocumentList')->name('document.list');

  Route::get('api/get-gallery-list', 'AjaxController@getGalleryList')->name('gallery.list');
  


    /**
      *  Routes To be Deleted after testing @Wasim
      */ 
	    Route::get('/document', function() {
	    $data = DB::table('documents')
			->where('companyid', session('companyid'))
			->get() ;
	    return $data;
	   });

  /*--------------------------------------------------------------------------------------------------------*/

Route::get('/due-diligence-process', 'DueDiligenceController@getDueDiligenceProcess')->middleware('auth');
Route::get('ajax-getquestions','DueDiligenceController@getModuleQuestions');
Route::get('ajax-getanswers','DueDiligenceController@getQuestionAnswers');

Route::post('ajax-new-answer','DueDiligenceController@postNewAnswer');
Route::post('question-search','DueDiligenceController@searchQuestions');

Route::get('/due-diligence-dashboard', 'DueDiligenceController@getDueDiligenceDashboard')->middleware('auth');


Route::get('/companymessaging', 'MessageController@getUserRecentFriends');
Route::get('getmessage', 'MessageController@getmessageasif');
Route::post('/getgroupid', 'MessageController@getgroupid');
Route::post('/postchatmessage', 'MessageController@postnewmessage');
Route::post('companymessaging-user-search','MessageController@getcompanyusersbysearch');
Route::post('companymessaging-user-check','MessageController@getcompanyusersbycheck');
Route::post('/updatecompanymessage','MessageController@updatecompanymessage');
Route::post('/deletecompanymessage','MessageController@deletecompanymessage');



Route::get('/messaging', 'DueDiligenceController@getDealMessaging')->middleware('auth');
Route::get('getpipelinedealmessages', 'DueDiligenceController@getmessageconversation');
Route::post('/postdealnewmessage','DueDiligenceController@postpipelinedealnewmessage');
Route::get('loadmore-pipelinedealmessages','DueDiligenceController@loadMoreDealMessages');
Route::post('/deletepipelinedealmessage','DueDiligenceController@deletepipelinedealmessage');
Route::post('/updatepipelinedealmessage','DueDiligenceController@updatepipelinedealmessage');
Route::post('pipelinedeal-user-search','DueDiligenceController@getpipelinedealusersbysearch');
Route::get('getmodulestoedit','DueDiligenceController@getmodulestoedit');
Route::post('/update-modules','DueDiligenceController@updatemodules');
Route::post('/create-new-module','DueDiligenceController@createnewmodule');
Route::post('/delete-modules','DueDiligenceController@deletemodules');
Route::post('/add-new-question','DueDiligenceController@createquestion');
Route::post('/update-previous-reply','DueDiligenceController@updatepreviousreply');
Route::post('/delete-previous-reply','DueDiligenceController@deletepreviousreply');

Route::get('/content', 'ContentController@getcontent');

Route::get('/content/{slug}','ContentController@getslugcontent');

Route::post('/content/report-bugs','ContentController@emailsave');


Route::get('/teams', 'TeamController@getteam');
Route::post('/teams/search','TeamController@gettable');
Route::post('/teams/filter','TeamController@getfilter');
Route::post('/teams/status','TeamController@setstatus');
Route::post('/teams/checkemail','TeamController@checkmail');
Route::post('/teams/usersaveupdate','TeamController@usersaveupdate');
Route::post('/teams/multipleinvite',['as' => 'multi_invite', 'uses' => 'TeamController@userinvite']);
Route::get('/teams/deleteinvited','TeamController@deleteinvited');


Route::post('/deleterequest','FriendController@deleterequest');


Route::post('/friendrequest','FriendController@friendrequest');


Route::get('loadmore-messages','MessageController@loadMoreMessages');


Route::get('/dealpipeline', 'DealPipelineController@index')->middleware('auth');
Route::get('ajax-getdeals','DealPipelineController@getDeals');
Route::get('ajax-getdeal-folders','DealPipelineController@getDealFolders');
Route::post('/ajax-attach-deal','DealPipelineController@attachDealByShowInterest');

Route::get('login-information','TenantController@logininformation');
Route::post('logininformation','TenantController@savelogininformation');
Route::get('getstate','TenantController@getstates');
Route::get('getcity','TenantController@getcity');
Route::post('companyprofilesave','TenantController@companyprofilesave');
Route::post('cardsave','TenantController@cardsave');
Route::get('payandconfirm','TenantController@payandconfirm');
Route::get('getpaymentsuccess','TenantController@paymentsuccess');
Route::get('getpaymentfailure','TenantController@paymentfailure');
Route::get('/tenant/dashboard','TenantController@tenantlogin')->middleware('auth');
Route::post('/uploadtenantlogoimage','TenantController@uploadtenantlogoimage');
Route::post('/uploadtenantcoverimage','TenantController@uploadtenantcoverimage');
Route::post('/savetenantinfo','TenantController@savetenantinfo');
Route::get('/tenant_profile_confirmation','TenantController@tenantprofileconfirmation');
Route::get('/my-portfolio','MyPortfolioController@index');
Route::get('/getmessagecount','HeaderController@getmessagecount');
Route::get('/deals/new-deal','DealController@NewDeal');
Route::get('/deals/edit-deal','DealController@EditDeal');
Route::get('/deals/view-deal','DealController@ViewDeal')->middleware('auth');
Route::post('savenewdeal','DealController@SaveNewDeal');
Route::post('updatedeal','DealController@UpdateDeal');
Route::group(['middleware' => 'auth', 'prefix' => 'deal', 'as' => 'deal.'], function() {

  Route::post('logoCover/image/store', 'DealController@coverLogoUpdate')->name('cover.logo.image.store');
  Route::post('document/store', 'DealController@documentUpdate')->name('document.store');
  Route::post('video/store', 'DealController@videoUpdate')->name('video.store'); 
  

});

Route::post('/deal-delete-documents','DealController@deletedocuments');
Route::get('api/get-deal-document-list', 'AjaxController@getDealDocumentList')->name('deal_document.list');
//mydeals
Route::get('/my-deals','DealController@index')->middleware('auth');
Route::get('ajax-getmydeals','DealController@getDeals');
Route::get('visitorcount','VisitorController@getvisitorcount');


Route::post('create-new-pipelinedeal-folder','MyPortfolioController@CreateNewPipelineFolder');
Route::get('/ajax-get-my-pipelinedeals','MyPortfolioController@GetMyPipelineDeals');
Route::post('change-pipelinedeal-folder','MyPortfolioController@ChangePipelineDealFolder');
Route::post('start-pipelinedeal','MyPortfolioController@startpipelinedeal');



// - Starts (harshita) - //
Route::get('invite-register','UserController@invite');
Route::get('pre-register','UserController@preRegister');
Route::post('save-invite-register','UserController@inviteregister');
Route::post('save-pre-register','UserController@savepreregister');
// - Ends (harshita) - //

//asifsearch
Route::get('teammembersearch','UserController@teammembersearch');
Route::post('checkemailpreregister','TenantController@checemailpreregister');
Route::get('getsymbol','DealController@currencysymbol');
Route::get('getsymbolcompany','CompanyController@currencysymbol');

Route::get('myportfolio_inactive','MyPortfolioController@inactive');
Route::get('myportfolio_active','MyPortfolioController@active');
Route::get('myportfolio_archive','MyPortfolioController@archive');
//Route::get('/downloadPDF/{id}','UserDetailController@downloadPDF');



Route::get('/printpdf','DueDiligenceController@downloadPDF');

Route::get('/editquestion','DueDiligenceController@geteditquestion');
Route::post('/saveeditedquestion','DueDiligenceController@savequestion');

Route::get('/deleteselectedquestion','DueDiligenceController@deleteselectedquestion');
Route::get('/assignedusers','DueDiligenceController@assignedusers');
Route::post('/saveassignusers','DueDiligenceController@saveassignusers');
Route::get('ajax-getsubmitreply','DueDiligenceController@getsubmit');
Route::get('/ajax-update-questionstatus','DueDiligenceController@updatequestionstatus');
// -End (asif) - // 

Route::post('/pipelinedeal-delete-documents','DueDiligenceController@deletedocuments');
Route::get('api/get-pipelinedeal-document-list', 'AjaxController@getPipelineDealDocumentList')->name('pipelinedeal_document.list');
Route::get('/pipelinedeal-docs','DueDiligenceController@getpipelinedealdocuments');

Route::group(['middleware' => 'auth', 'prefix' => 'pipelinedeal', 'as' => 'pipelinedeal.'], function() {
   Route::post('document/store', 'DueDiligenceController@documentUpdate')->name('document.store');
});

Route::get('/getcompanylist','DueDiligenceController@getcompanylist');
Route::get('/checkfor-already-invited-ormember','DueDiligenceController@checkinvitingmember');
Route::get('/remove-invited-requested-associated-company','DueDiligenceController@removeassociatedcompany');
Route::get('/accept-new-company-request','DueDiligenceController@acceptNewCompanyRequest');

Route::post('/projectscompanydata','CompanyController@getprojectcompanylist');

Route::get('/generate-access-request','DealController@generateaccessrequest');

//Asif's New Routes-2018-07-13

Route::get('/autocompletetemplatebuild','CompanyController@autocompletetemplate');
Route::get('/tenantlandingpage','TenantController@checklandingpage');
Route::get('/edit-landing-page','TenantController@newlandingpage')->middleware('auth');
Route::post('tenant/logo/image/store', 'TenantController@tenantLogoUpdate')->name('tenant.logo.image.store');
Route::post('tenant/profile/update', 'TenantController@tenantProfileUpdate')->name('tenant.profile.update');
Route::post('tenant/blockheading/update', 'TenantController@tenantBlockHeadingUpdate')->name('tenant.blockheading.update');
Route::post('tenant/blockheading/aboutus', 'TenantController@tenantAboutUs')->name('tenant.aboutus.update');
Route::post('tenant/testimonial/update', 'TenantController@tenantTestimonial')->name('tenant.testimonial.update');
Route::post('tenant/faq/update', 'TenantController@tenantFaq')->name('tenant.faq.update');
Route::get('/landing_page_block_header','TenantController@blockheader');
Route::get('/landing_page_faq','TenantController@faq');
Route::get('/landing_page_slides','TenantController@slides');
Route::get('/landing_page_testimonial','TenantController@testimonial');
Route::get('/tenantcommonsearch','TenantController@search');
Route::get('/commonform','TenantController@commonform');
Route::post('/savenewpopupform','TenantController@savepopupform');
Route::post('/saveslide','TenantController@saveslide');
Route::post('/slideupdate','TenantController@slideupdate');
Route::post('/testimonialupdate','TenantController@testimonialupdate');
Route::post('/testimonial','TenantController@savetestimonial');
Route::post('/updatepopupform','TenantController@updatepopupform');
Route::get('/deletetenantlayout','TenantController@deletetenantlayout');
Route::get('/commonupdateform','TenantController@commonupdateform');
Route::get('/senderfriend','NetworkController@senderfriend');
//Route::get('/readmessage','messageController@readmessage');
Route::get('/setreadcount','MessageController@readmessage');
//End of New Routes From Asif

Route::get('/pending-requests','UserController@getallpendingrequests')->middleware('auth');
Route::get('/get-friend-requests','UserController@getfriendrequests');
Route::get('/get-team-member-requests','UserController@getnewteammemberrequests');
Route::get('/get-dd-requests-invites','DueDiligenceController@getduediligenceinvitesandrequests');
Route::get('/accept-invitation-tojoin-dd','DueDiligenceController@accept_invitationtojoin_dd');
Route::get('/reject-invitation-tojoin-dd','DueDiligenceController@rejectinvitation');
Route::post('/accept-reject-team-member-request','UserController@AcceptRejectTeamMemberRequest');


//Admin related route
Route::get('/admincompany', 'AdminController@company')->name('/admincompany')->middleware('auth');
Route::get('/admindeal','AdminController@deal')->middleware('auth');
Route::get('/adminuser','AdminController@user')->middleware('auth');
Route::get('/adminduediligence','AdminController@duediligence')->middleware('auth');
Route::get('/admintenant','AdminController@tenant')->middleware('auth');
Route::get('/gotouser','AdminController@gotouser');
Route::get('/gotoadmin','AdminController@gotoadmin');
Route::get('/maketenantactive','AdminController@maketenantactive');
Route::get('/maketenantinactive','AdminController@maketenantinactive');
Route::get('/gototenant','AdminController@gototenant');

//DD-Template Related Routes
Route::post('/createnewtemplate','AjaxController@createnewtemplate');
Route::get('/updatetemplate','AjaxController@updatetemplate');
Route::post('/createnewmodules','AjaxController@createnewmodules');
Route::get('/updatemodule','AjaxController@updatemodule');
Route::post('/createnewquestions','AjaxController@createnewquestions');
Route::get('/updatequestion','AjaxController@updatequestion');
Route::get('/dd-templates','AjaxController@opentemplatepage')->middleware('auth');
Route::get('/get-dd-templates-data','AjaxController@getddTemplateData');


//Tenants Related New Routs
Route::get('/tenant/company', 'TenantController@company')->middleware('auth');
Route::get('/tenant/deal','TenantController@deal')->middleware('auth');
Route::get('/tenant/user','TenantController@user')->middleware('auth');
Route::get('/tenant/duediligence','TenantController@duediligence')->middleware('auth');
Route::get('/tenant/profile/edit','TenantController@tenant_profile_edit')->middleware('auth');
Route::get('/tenant/profile/view','TenantController@tenant_profile_view')->middleware('auth');
Route::post('/update_tenant','TenantController@update_tenant');
Route::post('/savelogoimage','TenantController@savelogoimage');
Route::post('/savecoverimage','TenantController@savecoverimage');
Route::post('/saveprofileimage','TenantController@saveprofileimage');
//saveminilogo
Route::post('/saveminilogoimage','TenantController@saveminilogoimage');
//
Route::post('/update_tenant_company','TenantController@update_tenant_company');
Route::post('/update_tenant_card','TenantController@update_tenant_card');
Route::get('/makecompanyactive','AdminController@makecompanyactive');
Route::get('/makecompanyinactive','AdminController@makecompanyinactive');
Route::get('/tenant/requests', 'TenantController@openrequestpage')->middleware('auth');;
Route::get('/get-company-requests','TenantController@get_company_requests');
Route::get('/accept-decline-new-company-request','TenantController@Verify_Decline_Company_Requests');

Route::get('/admin/requests', 'AdminController@openrequestpage')->middleware('auth');
Route::get('/admin/dashboard', 'AdminController@get_admin_dashboard')->middleware('auth');
Route::get('/get-tenant-requests','AdminController@get_tenant_requests');
Route::get('/accept-decline-new-tenant-request','AdminController@Verify_Decline_Tenant_Requests');


//Language Related Routes
Route::get('/change/locale','AjaxController@ChangeLanguage');

Route::get('/change-dd-template','DueDiligenceController@ChangeDDTemplate');
Route::get('/change-dd-status','DueDiligenceController@ChangeDDStatus');

Route::get('/hidehelpform','UserController@hideform');
Route::get('/showhelpform','UserController@showform');

//for the tenant landing page view
Route::get('/landing','TenantLandingPageController@tenantview');

//for the tenant pdf
Route::get('tenant/invoice','TenantController@generatinginvoice')->middleware('auth');
//for changing the plan
Route::get('/changeplan','TenantController@changeplan')->middleware('auth');
//Account route
Route::get('/tenant/account','TenantController@viewaccount')->middleware('auth');;
//


//To Load DD Activities...
Route::get('/get-dd-activities','DueDiligenceController@Get_DD_Activities');

//for the forgot password link
Route::get('/forgotpassword','Auth\LoginController@forgotpassword');
Route::post('/postforgetpassword','Auth\LoginController@postforgetpassword');

Route::get('/tenant/profilecomplete','TenantController@profilecomplete');

//Account New Tasks Asif Khan
Route::get('/tenant/account/invoice','TenantController@invoice')->middleware('auth');;
Route::get('/tenant/account/paymentmethod','TenantController@paymentmethod')->middleware('auth');;
Route::get('/tenant/account/subscription','TenantController@subscriptionmethod')->middleware('auth');;
Route::get('/tenant/account/cancellation','TenantController@cancelmethod')->middleware('auth');;
Route::get('/cancelaccount','TenantController@cancelaccount')->middleware('auth');;

//Making webhooks for stripe
//Route::get('/webhook','WebHookStripeController@displayform');


Route::post(
  'stripe/webhook',
  '\App\Http\Controllers\WebHookStripeController@handleWebhook'
);





//To recharge tenant account
Route::get('tenant/account/recharge','TenantController@rechargemethod');
Route::get('/rechargeaccount','TenantController@rechargeaccount');

Route::post('/update_email_settings','TenantController@update_tenant_email_settings');
Route::get('/getsecondaryvalues','TenantController@getsecondaryvalues');
Route::post('/update_languages','TenantController@update_languages');

//For the thank you page
Route::get('/thankyoupage','TenantController@thankyoupage');
//Save multiple company invite
Route::post('savemultiplecompanyinvite','TenantController@savemultiplecompanyinvite')->middleware('auth');
//for import/export excel
Route::get('/downloadimport','ExcelController@downloadview')->middleware('auth');
Route::post('/downloadimportpost','ExcelController@downloadimportpost')->middleware('auth');

Route::get('enterprise-sector/chart','AjaxController@getSectorEnterpriseChart');
Route::get('sector/chart','AjaxController@getSectorChart');
Route::get('deal/piechart','AjaxController@getPieChart');
Route::get('dd/doughnutchart','AjaxController@getDoughnupChartData');

//For new tendar
Route::get('/mytender','TenderController@tenders')->middleware('auth');
Route::get('/open/tenders','TenderController@tenders')->middleware('auth');
Route::post('/savenewtender','TenderController@savenewtender');
Route::get('/gettenderview','TenderController@tenderview');
Route::post('/edittender','TenderController@edittender');
Route::get('/fetchthirdpartyusers','TenderController@fetchthirdpartyusers');
Route::get('/sendthirdparty','TenderController@sendthirdparty');
Route::post('/saveproposaldocs','TenderController@saveproposaldocs');
Route::get('/closetender','TenderController@closetender');
Route::get('/closed/tenders','TenderController@close')->middleware('auth');

Route::get('/ajax-get-my-tenders','TenderController@getTenderList')->middleware('auth');

Route::get('/get-new-tender-form','TenderController@GetTenderNewForm')->middleware('auth');
Route::get('/fetchdealdata','TenderController@GetDealsForTenderForm')->middleware('auth');

//For View Tender Area
Route::get('/ajax-get-other-tenders','TenderController@GetOtherCompanies_Tenders')->middleware('auth');
Route::get('/view-other-tenders','TenderController@ViewOtherTenders')->middleware('auth');
Route::get('/view-single-tender','TenderController@ViewSingleTender')->middleware('auth');
Route::get('/accept-public-tender','TenderController@AcceptTender')->middleware('auth');
Route::get('/tender/bidding','TenderController@tender_bidding_page')->middleware('auth');
Route::get('/check-bid-appropriate-for-submission','TenderController@CheckBidReadyForSubmit');
Route::get('/tender/bidding/view','TenderController@tender_bidding_view')->middleware('auth');
Route::post('/biddinginfosave','TenderController@biddinginfosave')->middleware('auth');
Route::get('/submit-bid','TenderController@FinalSubmitBid')->middleware('auth');

//New Changes 9172018 12:26
Route::get('/genttenderviewfromtenderid','TenderController@gettenderviewfromtenderid')->middleware('auth');
Route::get('/getcompanieslist','TenderController@getcompanieslist')->middleware('auth');
Route::get('/singleproposalview','TenderController@singleproposalview')->middleware('auth');
Route::get('/fetchcompanydata','TenderController@fetchcompanydata')->middleware('auth');

//

//New Changes 9192018 5:09
Route::get('/acceptbid','TenderController@acceptbid')->middleware('auth');
Route::get('/rejectbid','TenderController@rejectbid')->middleware('auth');

//For email campaign
Route::get('/tenant/emails', 'EmailCampaignController@email_campaign')->middleware('auth');
Route::get('/fetchcompanydata-ec', 'EmailCampaignController@getcompanylist_ec');
Route::post('/ajaxsendemail', 'EmailCampaignController@ajaxsendemail');
Route::get('/selectemailtemplate', 'EmailCampaignController@selectemailtemplate');

Route::get('/company-request-history', 'TenantController@get_company_previous_requests');
Route::get('/tenant-request-history', 'AdminController@get_tenant_previous_requests');



//New changes to find company data using ajax
Route::get('/getcompanydata','AdminController@getcompanydata');
Route::get('/getuserdata','AdminController@getuserdata');
Route::get('/getdealdata','AdminController@getdealdata');


Route::post('importExcel', 'ExcelImportController@importExcel');
Route::get('importcompany','ExcelImportController@importcompany');


//page related changes
Route::get('/tenant/pages','TenantController@pages')->middleware('auth');
Route::get('/getpagedata','TenantController@getpagedata');
Route::get('/tenant/create-page','TenantController@createpage');
Route::post('/create_update_page','TenantController@createupdatepage');
Route::get('/tenant/edit_tenant','TenantController@edittenant');
Route::post('/save_page_banner_image','TenantController@savepagebannerimage');
Route::get('/tenant/deletepage','TenantController@deletepage');



Route::get('/tp/{page}','TenantController@showpage');