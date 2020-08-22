<?php

namespace App\Console\Commands;

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use Illuminate\Console\Command;

class AddData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:products_categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add or update data in products and categories tables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        $categoriesJson = file_get_contents(base_path('storage/SomeStorage/categories.json'));
        $categoriesData = json_decode($categoriesJson,true);
       $resultForCategories = CategoryController::addCategoriesConsole($categoriesData);
        if($resultForCategories === true) {
            $this->info('Категории успешно добавленны');
        }else{
            $this->error($resultForCategories);
        }

        $productsJson = file_get_contents(base_path('storage/SomeStorage/products.json'));
        $productsData = json_decode($productsJson,true);
        $resultForProducts = ProductController::addProductsConsole($productsData);
        if($resultForProducts === true) {
            $this->info('Продукты успешно добавленны');
        }else{
            $this->error($resultForProducts);
        }
    }
}
