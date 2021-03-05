<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseInfrastructurePivotTable extends Migration
{
    public function up()
    {
        Schema::create('house_infrastructure', function (Blueprint $table) {
            $table->unsignedBigInteger('infrastructure_id');
            $table->foreign('infrastructure_id', 'infrastructure_id_fk_3248000')->references('id')->on('infrastructures')->onDelete('cascade');
            $table->unsignedBigInteger('house_id');
            $table->foreign('house_id', 'house_id_fk_3248000')->references('id')->on('houses')->onDelete('cascade');
        });
    }
}
