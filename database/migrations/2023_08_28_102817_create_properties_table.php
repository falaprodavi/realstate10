<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('ptype_id');            
            $table->string('amenities_id');            
            $table->string('property_name');            
            $table->string('property_slug');            
            $table->string('property_code');            
            $table->string('property_status');            
            $table->string('property_lowest_price')->nullable();            
            $table->string('property_max_price')->nullable();            
            $table->string('property_thumbnail');            
            $table->text('property_short_desc')->nullable();            
            $table->text('property_long_desc');            
            $table->string('property_bedrooms')->nullable();            
            $table->string('property_bathrooms')->nullable();            
            $table->string('property_garage')->nullable();            
            $table->string('property_size')->nullable();            
            $table->string('property_video')->nullable();            
            $table->string('property_address')->nullable();            
            $table->string('property_city')->nullable();            
            $table->string('property_state')->nullable();            
            $table->string('property_cep')->nullable();            
            $table->string('property_neighborhood')->nullable();            
            $table->string('property_latitude')->nullable();            
            $table->string('property_longitude')->nullable();            
            $table->string('property_features')->nullable();            
            $table->string('property_hot')->nullable();            
            $table->integer('agent_id')->nullable();            
            $table->string('status')->default(0);                    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
