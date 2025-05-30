<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTypesTable extends Migration
{
    public function up()
    {
        Schema::create('data_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('display_name_singular');
            $table->string('display_name_plural');
            $table->string('icon')->nullable();
            $table->string('model_name')->nullable();
            $table->string('controller')->nullable();
            $table->string('description')->nullable();
            $table->boolean('generate_permissions')->default(false);
            $table->boolean('server_side')->default(false);
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_types');
    }
}