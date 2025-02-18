<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seat_industry_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('scope')->default('user');
            $table->integer('user_id')->unsigned()->nullable();
            $table->bigInteger('corp_id')->unsigned()->nullable();
            $table->integer('alliance_id')->unsigned()->nullable();
            $table->string('name', 255);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });

        Schema::create('seat_industry_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('structure_id')->unsigned()->nullable();
            $table->string('name', 255);
            $table->string('structure_type', 16);
            $table->integer('system_id')->unsigned();
            $table->integer('rig1_type_id')->unsigned()->nullable();
            $table->integer('rig2_type_id')->unsigned()->nullable();
            $table->integer('rig3_type_id')->unsigned()->nullable();
        });

        Schema::create('seat_industry_profile_structures', function (Blueprint $table) {
            $table->bigInteger('profile_id')->unsigned();
            $table->bigInteger('structure_id')->unsigned();
            $table->primary(['profile_id', 'structure_id']);

            $table->string('production_type', 16);

            $table->foreign('profile_id')->references('id')->on('seat_industry_profiles')->onDelete('cascade');
            $table->foreign('structure_id')->references('id')->on('seat_industry_structures')->onDelete('cascade');
        });

        Schema::create('seat_industry_structure_bonuses', function (Blueprint $table) {
            $table->integer('structure_type_id')->unsigned();
            $table->integer('activity_type')->unsigned()->default(1);
            $table->integer('bonus_type')->unsigned()->default(1);
            $table->primary(['structure_type_id', 'activity_type', 'bonus_type']);

            $table->decimal('float_value')->default(0.0);
        });

        Schema::create('seat_industry_attributes', function (Blueprint $table) {
            $table->integer('activity_type')->unsigned()->default(1);
            $table->integer('production_type')->unsigned()->default(1);
            $table->integer('bonus_type')->unsigned()->default(1);
            $table->primary(['attribute_id', 'activity_type', 'production_type', 'bonus_type']);

            $table->integer('attribute_id')->unsigned();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seat_industry_profiles');
        Schema::dropIfExists('seat_industry_profile_structures');
        Schema::dropIfExists('seat_industry_structures');
        Schema::dropIfExists('seat_industry_structure_bonuses');
        Schema::dropIfExists('seat_industry_attributes');
    }
};