<?php

use App\Models\Feedback;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_logs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('due_date');
            $table->foreignIdFor(Project::class)->constrained()->cascadeOnDelete();
            $table->integer('log_num');
            $table->string('submission_name');
            $table->string('submission_path');
            $table->boolean('is_approved');
            $table->foreignIdFor(Feedback::class)->constrained()->cascadeOnDelete()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_logs');
    }
}
