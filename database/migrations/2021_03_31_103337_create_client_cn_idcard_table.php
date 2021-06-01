<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientCnIdcardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'client_cn_idcard';
        if(Schema::hasTable($table_name)){
            echo $table_name . " table already exist!\n";
        }else{
            Schema::create($table_name, function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->nullable(false)->unique();
                $table->string('type',100)->nullable(false);
                $table->string('idcard_face',100)->nullable(false);
                $table->string('idcard_back',100)->nullable(false);
                $table->char('gender',1)->nullable(false);
                $table->date('birthday')->nullable(false);
                $table->string('name_c',100)->nullable(false);
                $table->string('surname',100)->nullable(false);
                $table->string('given_name',100)->nullable(false);
                $table->string('idcard_no',100)->nullable(false)->unique();
                $table->string('idcard_address',100)->nullable(false);
                $table->string('issued_by',100)->nullable(false);
                $table->string('valid_date',100)->nullable(false);
                $table->string('status',100)->nullable(false)->default('unaudited');
                $table->text('remark')->nullable(false);
                $table->integer('count_of_audits')->nullable(false)->default('0');
                $table->date('closed_at')->nullable();
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
        // Schema::dropIfExists('client_cn_idcard');
    }
}
