<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Index routes
Route::group(['middleware' => ['web']], function () {
    Route::get('/addPromo', 'BaseController@addPromo');
    Route::get('/apple-app-site-association', 'BaseController@showIosFile');
    Route::get('/', function () {
        return redirect('/auth');
    });
    Route::match(['get', 'post'], '/test', 'PagesController@test');
//    Route::get('/', function () {
//        return view('index');
//    });
//    Route::get('/login', function () {
//        return redirect('/auth');
//    });
});

Route::auth();

// --------------------------------------------------------------- Api routes------------------------------------------

Route::group(['middleware' => ['web']], function () {

    Route::get('auth/{provider}/callback', 'Admin\AuthController@getAccessToken');
    Route::post('auth/register-apple', 'Admin\AuthController@signApple');
    Route::post('auth/forgot', 'Admin\AuthController@forgot');

    Route::post('auth/{provider}/{access_token}', ['as' => 'social_auth', 'uses' => 'Admin\AuthController@socialLogin',]);

    Route::get('city', 'CityController@index');
    Route::resource('language', 'LanguageController');
    Route::resource('category', 'CategoryController');
    Route::get('faq','FaqFeedbackController@faq');
    Route::get('reason','FaqFeedbackController@reason');
    Route::post('create-feedback', ['as' => 'create_feedback', 'uses' => 'FaqFeedbackController@store']);
    Route::resource('settings', 'SettingsController');

    Route::get('pages/names', 'PagesController@names');
    Route::get('pages/by-name/{name}', 'PagesController@byName');
    Route::resource('pages', 'PagesController', ['parameters' => ['pages' => 'page']]);

    Route::post('profile','ProfileController@update');
    Route::post('profile/buy-quest',['as'=>'buy_quest', 'uses'=>'ProfileController@buyQuest']);
    Route::post('profile/add-promocode-discount', ['as' => 'profile_promocode_discount', 'uses' => 'ProfileController@promocodeDiscount']);
    Route::post('profile/add-promocode',['as'=>'profile_promocode', 'uses'=>'ProfileController@promocode']);
    Route::post('profile/sendstatistic',['as'=>'send_statistic', 'uses'=>'ProfileController@sendStatistic']);
    Route::get('profile/{userID?}','ProfileController@show');

    Route::get('quests/product-ids', 'QuestController@productIDS');
    Route::post('quests/setmark', 'QuestController@setMark');
    Route::get('quests/by-product-id/{product_id}', 'QuestController@byProductId');
    Route::post('quests/update-status/{questID}', ['as' => 'update_status', 'uses' => 'QuestController@updateStatus']);
    Route::resource('quests', 'QuestController', ['parameters' => ['quests' => 'quest']]);
    Route::get('quests/{questID}/questions', 'QuestController@questions');
    Route::get('quests-pages', 'QuestController@pages', ['parameters' => ['quests' => 'quest']]);


    Route::get('questions/{questionID}', 'QuestController@question');
    Route::get('questions/{questionID}/answer', 'QuestController@answer');
    Route::get('questions/{questionID}/hints', 'QuestController@hints');

    Route::get('answers/types', 'QuestController@answerTypes');
    Route::get('answers/{answerID}', 'QuestController@answerById');

    Route::get('hints/{hintID}', 'QuestController@hint');
});

// --------------------------------------------------------------- Admin routes------------------------------------------

Route::get('/admin', function () {
    return redirect()->route('admin_dashboard');
});
Route::match(['get', 'post'], '/auth', ['uses' => 'Admin\AuthController@auth', 'as' => 'admin_auth']);
Route::get('/logout', 'Admin\AuthController@logout');


//------------------------------- Admin --------------------

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth', 'admin']], function () {

//----------------------------------------------------------

    // Dashboard
    Route::match(['get', 'post'], '/', [
        'uses' => 'Admin\AdminController@dashboard',
        'as' => 'admin_dashboard'
    ]);

//----------------------------------------------------------

    // Quests
    Route::get('/quests/list', [
        'uses' => 'Admin\AdminQuestsController@listItems',
        'as' => 'admin_quests_list'
    ]);
    Route::match(['get', 'post'], '/quests/edit/{id?}', [
        'uses' => 'Admin\AdminQuestsController@editItems',
        'as' => 'admin_quests_edit'
    ]);
    Route::post('/quests/delete', [
        'uses' => 'Admin\AdminQuestsController@deleteItems',
        'as' => 'admin_quests_delete'
    ]);
    Route::post('ajaxSortQuests', [
        'uses' => 'Admin\AdminQuestsController@ajaxSortQuests',
        'as' => 'admin_ajax_sort_quests',
    ]);

//----------------------------------------------------------

    // Phrases
    Route::get('/phrases/list/{questID}', [
        'uses' => 'Admin\AdminQuestsPhrasesController@listItems',
        'as' => 'admin_phrases_list'
    ]);
    Route::match(['get', 'post'], '/phrases/edit/quest/{id}/{phrase?}/{questID?}', [
        'uses' => 'Admin\AdminQuestsPhrasesController@editItems',
        'as' => 'admin_phrases_edit'
    ]);
    Route::post('/phrases/delete', [
        'uses' => 'Admin\AdminQuestsPhrasesController@deleteItems',
        'as' => 'admin_phrases_delete'
    ]);

//----------------------------------------------------------

    // Logs
    Route::get('/logs/list/', [
        'uses' => 'Admin\AdminLogsController@listItems',
        'as' => 'admin_logs_list'
    ]);
    Route::match(['get', 'post'], '/logs/edit/{logID}', [
        'uses' => 'Admin\AdminLogsController@editItems',
        'as' => 'admin_logs_edit'
    ]);
    Route::get('/logs/delete', [
        'uses' => 'Admin\AdminLogsController@deleteItems',
        'as' => 'admin_logs_delete'
    ]);

//----------------------------------------------------------

    // Appearance
    Route::post('/appearances/edit/{id?}', [
        'uses' => 'Admin\AdminQuestsAppearancesController@editItems',
        'as' => 'admin_quests_appearances_edit'
    ]);

//----------------------------------------------------------

    // Questions
    Route::get('/questions/list/{questID}', [
        'uses' => 'Admin\AdminQuestsQuestionsController@listItems',
        'as' => 'admin_questions_list'
    ]);
    Route::match(['get', 'post'], '/questions/edit/quest/{id}/{question?}/{questionID?}', [
        'uses' => 'Admin\AdminQuestsQuestionsController@editItems',
        'as' => 'admin_questions_edit'
    ]);
    Route::post('/questions/delete', [
        'uses' => 'Admin\AdminQuestsQuestionsController@deleteItems',
        'as' => 'admin_questions_delete'
    ]);
    Route::post('ajaxSortQuestions', [
        'uses' => 'Admin\AdminQuestsQuestionsController@ajaxSortQuestions',
        'as' => 'admin_ajax_sort_questions',
    ]);

    // Question components
    Route::post('ajaxAddQuestionDescription', [
        'uses' => 'Admin\AdminQuestsQuestionsController@ajaxAddQuestionDescription',
        'as' => 'admin_ajax_add_question_description',
    ]);
    Route::post('ajaxAddQuestionFile', [
        'uses' => 'Admin\AdminQuestsQuestionsController@ajaxAddQuestionFile',
        'as' => 'admin_ajax_add_question_file',
    ]);
    Route::post('ajaxAddQuestionTimer', [
        'uses' => 'Admin\AdminQuestsQuestionsController@ajaxAddQuestionTimer',
        'as' => 'admin_ajax_add_question_timer',
    ]);

//----------------------------------------------------------

    // Answers
    Route::match(['get', 'post'], '/answers/edit/question/{questionID}/answer/{answerID}', [
        'uses' => 'Admin\AdminQuestsAnswersController@editItems',
        'as' => 'admin_answers_edit'
    ]);

    // Answers components
    Route::post('ajaxChangeAnswerComponent', [
        'uses' => 'Admin\AdminQuestsAnswersController@ajaxChangeAnswerComponent',
        'as' => 'admin_ajax_change_answer_component',
    ]);
    Route::post('ajaxAddAnswerComponent', [
        'uses' => 'Admin\AdminQuestsAnswersController@ajaxAddAnswerComponent',
        'as' => 'admin_ajax_add_answer_component',
    ]);

//----------------------------------------------------------

    // Hints
    Route::get('/hints/list/{questionID}', [
        'uses' => 'Admin\AdminQuestsHintsController@listItems',
        'as' => 'admin_hints_list'
    ]);
    Route::match(['get', 'post'], '/hints/edit/question/{questionID}/{hint?}/{hintID?}', [
        'uses' => 'Admin\AdminQuestsHintsController@editItems',
        'as' => 'admin_hints_edit'
    ]);
    Route::post('/hints/delete', [
        'uses' => 'Admin\AdminQuestsHintsController@deleteItems',
        'as' => 'admin_hints_delete'
    ]);
    Route::post('ajaxSortHints', [
        'uses' => 'Admin\AdminQuestsHintsController@ajaxSortHints',
        'as' => 'admin_ajax_sort_hints',
    ]);

    // Hints components
    Route::post('ajaxAddHintDescription', [
        'uses' => 'Admin\AdminQuestsHintsController@ajaxAddHintDescription',
        'as' => 'admin_ajax_add_hint_description',
    ]);
    Route::post('ajaxAddHintFile', [
        'uses' => 'Admin\AdminQuestsHintsController@ajaxAddHintFile',
        'as' => 'admin_ajax_add_hint_file',
    ]);

//----------------------------------------------------------

    // Categories
    Route::get('/categories/list', [
        'uses' => 'Admin\AdminCategoriesController@listItems',
        'as' => 'admin_categories_list'
    ]);
    Route::match(['get', 'post'], '/categories/edit/{id?}', [
        'uses' => 'Admin\AdminCategoriesController@editItems',
        'as' => 'admin_categories_edit'
    ]);
    Route::post('/categories/delete', [
        'uses' => 'Admin\AdminCategoriesController@deleteItems',
        'as' => 'admin_categories_delete'
    ]);
    Route::post('ajaxSortCategories', [
        'uses' => 'Admin\AdminCategoriesController@ajaxSortCategories',
        'as' => 'admin_ajax_sort_categories',
    ]);

//----------------------------------------------------------

    // Cities
    Route::get('/cities/list', [
        'uses' => 'Admin\AdminCitiesController@listItems',
        'as' => 'admin_cities_list'
    ]);
    Route::match(['get', 'post'], '/cities/edit/{id?}', [
        'uses' => 'Admin\AdminCitiesController@editItems',
        'as' => 'admin_cities_edit'
    ]);
    Route::post('/cities/delete', [
        'uses' => 'Admin\AdminCitiesController@deleteItems',
        'as' => 'admin_cities_delete'
    ]);

//----------------------------------------------------------

    // Errors
    Route::get('/errors/list', [
        'uses' => 'Admin\AdminErrorsController@listItems',
        'as' => 'admin_errors_list'
    ]);
    Route::match(['get', 'post'], '/errors/edit/{id?}', [
        'uses' => 'Admin\AdminErrorsController@editItems',
        'as' => 'admin_errors_edit'
    ]);
//    Route::post('/errors/delete', [
//        'uses' => 'Admin\AdminErrorsController@deleteItems',
//        'as' => 'admin_errors_delete'
//    ]);

//----------------------------------------------------------

    // Languages
    Route::get('/languages/list', [
        'uses' => 'Admin\AdminLanguagesController@listItems',
        'as' => 'admin_languages_list'
    ]);
    Route::match(['get', 'post'], '/languages/edit/{id?}', [
        'uses' => 'Admin\AdminLanguagesController@editItems',
        'as' => 'admin_languages_edit'
    ]);
    Route::post('/languages/delete', [
        'uses' => 'Admin\AdminLanguagesController@deleteItems',
        'as' => 'admin_languages_delete'
    ]);

//----------------------------------------------------------

    // Users
    Route::get('/users/list', [
        'uses' => 'Admin\AdminUsersController@listItems',
        'as' => 'admin_users_list'
    ]);
    Route::match(['get', 'post'], '/users/edit/{id?}', [
        'uses' => 'Admin\AdminUsersController@editItems',
        'as' => 'admin_users_edit'
    ]);
    Route::post('/users/delete', [
        'uses' => 'Admin\AdminUsersController@deleteItems',
        'as' => 'admin_users_delete'
    ]);

//----------------------------------------------------------

    // Roles
    Route::get('/roles/list', [
        'uses' => 'Admin\AdminRolesController@listItems',
        'as' => 'admin_roles_list'
    ]);
    Route::match(['get', 'post'], '/roles/edit/{id?}', [
        'uses' => 'Admin\AdminRolesController@editItems',
        'as' => 'admin_roles_edit'
    ]);
    Route::post('/roles/delete', [
        'uses' => 'Admin\AdminRolesController@deleteItems',
        'as' => 'admin_roles_delete'
    ]);

//----------------------------------------------------------

    // Pages
    Route::get('/pages/list', [
        'uses' => 'Admin\AdminPagesController@listItems',
        'as' => 'admin_pages_list'
    ]);
    Route::match(['get', 'post'], '/pages/edit/{id?}', [
        'uses' => 'Admin\AdminPagesController@editItems',
        'as' => 'admin_pages_edit'
    ]);
    Route::post('/pages/delete', [
        'uses' => 'Admin\AdminPagesController@deleteItems',
        'as' => 'admin_pages_delete'
    ]);

//----------------------------------------------------------

    // Faqs
    Route::get('/faqs/list', [
        'uses' => 'Admin\AdminFaqsController@listItems',
        'as' => 'admin_faqs_list'
    ]);
    Route::match(['get', 'post'], '/faqs/edit/{id?}', [
        'uses' => 'Admin\AdminFaqsController@editItems',
        'as' => 'admin_faqs_edit'
    ]);
    Route::post('/faqs/delete', [
        'uses' => 'Admin\AdminFaqsController@deleteItems',
        'as' => 'admin_faqs_delete'
    ]);
    Route::post('ajaxSortFaqs', [
        'uses' => 'Admin\AdminFaqsController@ajaxSortFaqs',
        'as' => 'admin_ajax_sort_faqs',
    ]);

//----------------------------------------------------------

    // Promocodes
    Route::get('/promocodes/list', [
        'uses' => 'Admin\AdminPromocodesController@listItems',
        'as' => 'admin_promocodes_list'
    ]);
    Route::match(['get', 'post'], '/promocodes/edit/{id?}', [
        'uses' => 'Admin\AdminPromocodesController@editItems',
        'as' => 'admin_promocodes_edit'
    ]);
    Route::post('/promocodes/delete', [
        'uses' => 'Admin\AdminPromocodesController@deleteItems',
        'as' => 'admin_promocodes_delete'
    ]);

//----------------------------------------------------------

    // Feedback reasons
    Route::get('/reasons/list', [
        'uses' => 'Admin\AdminFeedbackReasonsController@listItems',
        'as' => 'admin_reasons_list'
    ]);
    Route::match(['get', 'post'], '/reasons/edit/{id?}', [
        'uses' => 'Admin\AdminFeedbackReasonsController@editItems',
        'as' => 'admin_reasons_edit'
    ]);
    Route::post('/reasons/delete', [
        'uses' => 'Admin\AdminFeedbackReasonsController@deleteItems',
        'as' => 'admin_reasons_delete'
    ]);

//----------------------------------------------------------

    // Feedback
    Route::get('/feedback/list', [
        'uses' => 'Admin\AdminFeedbacksController@listItems',
        'as' => 'admin_feedback_list'
    ]);
    Route::post('/feedback/delete', [
        'uses' => 'Admin\AdminFeedbacksController@deleteItems',
        'as' => 'admin_feedback_delete'
    ]);

//----------------------------------------------------------

    // Statistic
    Route::match(['get', 'post'], '/statistics/list', [
        'uses' => 'Admin\AdminStatisticsController@listItems',
        'as' => 'admin_statistics_list'
    ]);
    Route::get('/statistics/show/{id}', [
        'uses' => 'Admin\AdminStatisticsController@showItem',
        'as' => 'admin_statistics_show'
    ]);
    Route::post('/statistics/delete', [
        'uses' => 'Admin\AdminStatisticsController@deleteItems',
        'as' => 'admin_statistics_delete'
    ]);
    Route::match(['get', 'post'], '/statistics/users/data', [
        'uses' => 'Admin\AdminStatisticsController@usersData',
        'as' => 'admin_statistics_users_data'
    ]);

//----------------------------------------------------------

    // Settings
    Route::match(['get', 'post'], '/settings/edit', [
        'uses' => 'Admin\AdminSettingsController@editItems',
        'as' => 'admin_settings_edit'
    ]);

//----------------------------------------------------------

    // Helpers
    Route::post('ajaxDeleteImages', [
        'uses' => 'Admin\Misc\Helpers@ajaxDeleteImages',
        'as' => 'admin-ajax-delete-images',
    ]);

//----------------------------------------------------------

});
