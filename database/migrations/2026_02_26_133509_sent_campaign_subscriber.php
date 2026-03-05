<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SentCampaignSubscriber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_campaign_subscribers', function (Blueprint $table) {
            $table->id();
            $table->integer('sent_campaign_id');
            $table->integer('group_id');
            $table->integer('subscriber_id');
            $table->string('mailing_type');
            $table->tinyInteger('is_sent')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sent_campaign_subscribers');
    }
}
