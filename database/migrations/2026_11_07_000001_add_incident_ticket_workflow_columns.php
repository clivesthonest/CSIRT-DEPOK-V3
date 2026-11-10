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
        Schema::table('incident_reports', function (Blueprint $table) {
            $table->string('ticket_number')->nullable()->unique()->after('id');
            $table->string('source')->nullable()->after('kategori');
            $table->string('impact_area')->nullable()->after('source');
            $table->dateTime('waktu_kejadian')->nullable()->after('impact_area');
            $table->string('triage_status')->nullable()->after('waktu_kejadian');
            $table->string('validation_status')->nullable()->after('triage_status');
            $table->string('last_status_update')->nullable()->after('status');
            $table->json('timeline')->nullable()->after('last_status_update');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incident_reports', function (Blueprint $table) {
            $table->dropColumn(['ticket_number', 'source', 'impact_area', 'waktu_kejadian', 'triage_status', 'validation_status', 'last_status_update', 'timeline']);
        });
    }
};
