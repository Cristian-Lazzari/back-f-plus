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

            $table->boolean('active')->default(false);             //dati servizio
            $table->tinyInteger('status')->default(false);                // 1 essentials, 2 w-on, 3 b-up, 4 prova gratuita 
            
            // $table->string('name_agency', 30)->nullable();      //dati Azienda
            $table->tinyInteger('type_agency')->nullable();           // 1 ditta ind., 2 azienda, 3 libero prof
            $table->string('pec', 60)->nullable();                 
            $table->string('address', 60)->nullable();                 
            $table->string('vat', 20)->nullable();
            
            $table->string('name', 50);                            //dati personali
            $table->string('surname', 50);
            $table->string('birth_date', 11)->nullable();
            $table->string('cf', 20)->nullable();
            
            $table->string('phone', 15)->nullable();               //dati per contattarlo
            
            $table->text('menu')->nullable();
            $table->string('domain')->unique()->nullable();
            $table->text('r_property')->nullable();

            $table->text('opening_times')->nullable();
            $table->text('services_times')->nullable();

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
