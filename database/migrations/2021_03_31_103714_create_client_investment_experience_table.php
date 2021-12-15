<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateClientInvestmentExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client_investment_experience';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->nullable(false)->unique();
                $table->string('investment_objective',100)->nullable(false);
                $table->string('other_investment_objective',255)->nullable();
                $table->string('stock',100)->nullable(false);
                $table->string('derivative_warrants',100)->nullable(false);
                $table->string('cbbc',100)->nullable(false);
                $table->string('futures_and_options',100)->nullable(false);
                $table->string('bonds_funds',100)->nullable(false);
                $table->string('other_investment_experience',255)->nullable();
                $table->string('status',100)->nullable(false)->default('unaudited');
                $table->text('remark')->nullable();
                $table->integer('count_of_audits')->nullable(false)->default('0');
                $table->timestamps();
            });

            Schema::table($table_name, function (Blueprint $table) use($table_name) {
                DB::statement('ALTER TABLE '.$table_name.' MODIFY COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP');
                DB::statement('ALTER TABLE '.$table_name.' MODIFY COLUMN updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('client_investment_experience');
    }
}
