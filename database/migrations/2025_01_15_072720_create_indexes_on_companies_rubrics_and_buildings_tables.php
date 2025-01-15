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
        Schema::table('companies', function(Blueprint $table)
        {
            print_r($table->index('building_id'));
        });

        Schema::table('company_rubric', function(Blueprint $table)
        {
            print_r($table->index('rubric_id'));
            print_r($table->index('company_id'));
        });

        Schema::table('buildings', function(Blueprint $table)
        {
            print_r($table->index('latitude'));
            print_r($table->index('longitude'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table)
        {
            print_r($table->dropIndex(['building_id']));
        });

        Schema::table('company_rubric', function(Blueprint $table)
        {
            print_r($table->dropIndex(['rubric_id']));
            print_r($table->dropIndex(['company_id']));
        });

        Schema::table('buildings', function(Blueprint $table)
        {
            print_r($table->dropIndex(['latitude']));
            print_r($table->dropIndex(['longitude']));
        });
    }
};
