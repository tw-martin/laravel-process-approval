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
        $tenantField = config('process_approval.multi_tenancy_field', 'tenant_id');
        Schema::table('process_approval_flow_steps', static function (Blueprint $table) {
            $table->string($tenantField, 38)->index()->nullable()->after('active');
        });
        Schema::table('process_approvals', static function (Blueprint $table) {
            $table->string($tenantField, 38)->index()->nullable()->after('user_id');
        });
        Schema::table('process_approval_statuses', static function (Blueprint $table) {
            $table->string($tenantField, 38)->index()->nullable()->after('creator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tenantField = config('process_approval.multi_tenancy_field', 'tenant_id');
        if(Schema::hasColumn('process_approval_flow_steps', 'tenant_id')) {
            Schema::table('process_approval_flow_steps', static function (Blueprint $table) {
                $table->dropColumn($tenantField);
            });
        }
        if(Schema::hasColumn('process_approvals', 'tenant_id')) {
            Schema::table('process_approvals', static function (Blueprint $table) {
                $table->dropColumn($tenantField);
            });
        }
        if(Schema::hasColumn('process_approval_statuses', 'tenant_id')) {
            Schema::table('process_approval_statuses', static function (Blueprint $table) {
                $table->dropColumn($tenantField);
            });
        }
    }
};
