<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumers', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        //{
            $table->boolean('active')->default(false);             //dati servizio
            $table->tinyInteger('status')->default(4);            // 1 essentials, 2 w-on, 3 b-up, 4 prova gratuita 
            $table->string('discount')->default('0');            
        //}   
            $table->string('activity_name')->nullable();           //dati Azienda
            $table->string('pec', 60)->nullable();               
            $table->string('address', 60)->nullable();                 
            $table->string('vat', 20)->nullable();
            $table->tinyInteger('type_agency')->nullable();           // 1 ditta ind., 2 azienda, 3 libero prof
            $table->string('owner_name', 50)->nullable();                            
            $table->string('owner_surname', 50)->nullable();
            $table->string('owner_cf', 20)->nullable();
            $table->string('owner_bd', 20)->nullable();
            $table->string('owner_sex', 2)->nullable();
            $table->string('owner_phone', 20)->nullable();
            $table->string('owner_cm', 3)->nullable();
        //}    
            
        //}
            $table->text('menu')->nullable();                      //dati ristorante
            $table->tinyInteger('services_type')->nullable();         // 1 as/dom - tav, 2 as/dom, 3 tav
            $table->text('domain')->nullable();

            $table->text('r_property')->nullable();
            $table->text('r_style')->nullable();

        //}
            //$table->text('palette');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumers');
    }
};
