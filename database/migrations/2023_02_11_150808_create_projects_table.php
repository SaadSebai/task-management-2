<?php

use App\Enums\ProjectStatuses;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default(ProjectStatuses::TO_DO->value);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->foreignIdFor(Team::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignIdFor(User::class, 'creator_id')
                ->nullable()
                ->constrained('users', 'id')
                ->nullOnDelete();

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
        Schema::dropIfExists('projects');
    }
};
