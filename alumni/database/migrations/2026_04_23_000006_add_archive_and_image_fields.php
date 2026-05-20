<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('location');
            $table->timestamp('archived_at')->nullable()->after('image_path');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'archived_at']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};
