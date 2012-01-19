#!/usr/bin/perl -w
#
# Copyright (c) 2002 Steve Price
# All rights reserved.
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions
# are met:
#
# 1. Redistributions of source code must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
# 2. Redistributions in binary form must reproduce the above copyright
#    notice, this list of conditions and the following disclaimer in the
#    documentation and/or other materials provided with the distribution.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
# ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
# FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
# DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
# OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
# HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
# LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
# OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
# SUCH DAMAGE.
#
# $srp: godealertodealer.com/cgi-bin/close_auctions.pl,v 1.25 2004/04/19 16:16:06 steve Exp $
#

use DBI;
use Fcntl qw(:DEFAULT :flock);

use CGI::Carp qw(fatalsToBrowser);

use strict;


my $email_from = '"DEALER TO DEALER L.L.C." <info@godealertodealer.com>';

sub sendMail($$$$) {
    my ($from, $to, $subject, $msg) = @_;

    open(MAIL, "| /usr/sbin/sendmail -oem -f '$from' '$to'") || return;
    print MAIL <<END_of_message;
To: $to
From: $from
Subject: $subject

$msg
END_of_message
    close(MAIL);
}

sub CommaFormatted
{
	my $delimiter = ','; # replace comma if desired
	my($n,$d) = split /\./,shift,2;
	my @a = ();
	while($n =~ /\d\d\d\d/)
	{
		$n =~ s/(\d\d\d)$//;
		unshift @a,$1;
	}
	unshift @a,$n;
	$n = join $delimiter,@a;
	$n = "$n\.$d" if $d =~ /\d/;
	return $n;
}

MAIN: {


  # Poor attempt at keeping other processes from getting in and changing
  # things behind our back.
    chomp(my $lockfile = `basename $0`);
    $lockfile = "/var/tmp/" . $lockfile . "_test.lock";

    sysopen(FH, "$lockfile", O_CREAT|O_NONBLOCK);
    exit unless (flock(FH, LOCK_EX|LOCK_NB));

    my $database   = 'godealertodealer';
    my $dbPassword = 'gdtdJiL';
    my $dbUser     = 'gdtd';
    my $driver     = 'mysql';
    my $host       = 'localhost';
    my $dsn        = "DBI:$driver:database=$database;host=$host";
  
  # Open connection to the database.
    my $dbh = DBI->connect($dsn, $dbUser, $dbPassword, {'RaiseError' => 1});

  # Lock the pops table to make sure things don't change out from underneath
  # us.  Probably need to rethink this at some point when the number of changes
  # between runs gets large.
    $dbh->do("LOCK TABLES auctions WRITE, vehicles READ, bids WRITE, dealers READ, " .
      "users READ");

  # Get a list of the open auctions that should be closed.
    my $sth = $dbh->prepare("SELECT auctions.id, auctions.title, " .
      "DATE_FORMAT(auctions.starts, '%a %c/%e/%y %l:%i%p') as starts, " .
      "DATE_FORMAT(auctions.ends, '%a %c/%e/%y %l:%i%p') as ends, " .
      "auctions.description, auctions.minimum_bid, users.username, " .
      "auctions.buy_now_price, auctions.reserve_price, auctions.current_bid, " .
      "auctions.winning_bid, auctions.vehicle_id, users.id AS seller_id, " .
      "vehicles.vin, vehicles.hin, vehicles.stock_num, " .
      "users.email, users.first_name, users.last_name, users.phone, " .
      "users.address1, users.address2, users.city, users.state, users.zip, " .
      "dealers.id AS seller_did, dealers.has_sell_fee FROM auctions, users, " .
      "dealers, vehicles WHERE auctions.ends <= NOW() AND auctions.status='open' " .
      "AND auctions.user_id=users.id AND users.dealer_id=dealers.id " . 
      "AND auctions.vehicle_id=vehicles.id ");
    $sth->execute();

  # Close each of the auctions.
    my %auctions = ();
    while (my $href = $sth->fetchrow_hashref()) {
        my $id = $href->{'id'};

        $auctions{$id} = $href;
        $dbh->do("UPDATE auctions SET status='closed' WHERE id='$id'");
    }

    $sth->finish();

  # Unlock tables.
    $dbh->do("UNLOCK TABLES");

  # Now go back and figure out the outcome of each auction that we closed.
    foreach my $id (keys %auctions) {
        my $href          = $auctions{$id};
        my $amount        = $href->{'current_bid'};
        my $seller_email  = $href->{'email'};
        my $seller_phone  = $href->{'phone'};
        my $seller_name   = $href->{'first_name'} . ' ' . $href->{'last_name'};
        my $seller_uname  = $href->{'username'};
        my $title         = $href->{'title'};
        my $vid           = $href->{'vehicle_id'};
        my $winning_bid   = $href->{'winning_bid'};
        my $description   = $href->{'description'};
        my $buy_now_price = $href->{'buy_now_price'};
        my $reserve_price = $href->{'reserve_price'};
        my $minimum_bid   = $href->{'minimum_bid'};
        my $starts        = $href->{'starts'};
        my $ends          = $href->{'ends'};
        my $stock_num     = $href->{'stock_num'};
        my $hin           = $href->{'hin'};
        my $vin           = $href->{'vin'};
        my $dealer_id     = $href->{'seller_did'};
        my $seller_id     = $href->{'seller_id'};
        my $seller_address= $href->{'address1'} . ' ' . $href->{'address2'};
        my $seller_city   = $href->{'city'};
        my $seller_state  = $href->{'state'};
        my $seller_zip    = $href->{'zip'};
        my $has_sell_fee  = $href->{'has_sell_fee'};
        
        #convert to formating
        my $amount_num = CommaFormatted($amount);
        my $minimum_bid_num = CommaFormatted($minimum_bid);
        my $reserve_price_num = CommaFormatted($reserve_price);
        my $buy_now_price_num = CommaFormatted($buy_now_price);
                    
        if ($winning_bid &&
          $href->{'current_bid'} >= $href->{'reserve_price'}) {
          # Determine buyer's email address given the winning bid ID.

            $sth = $dbh->prepare("SELECT users.id, users.dealer_id, " .
              "users.first_name, users.last_name, users.email, users.phone, " .
              "users.address1, users.address2, users.city, users.state, users.zip, " .
              "users.username FROM bids, users WHERE bids.id='$winning_bid' " .
              "AND bids.user_id=users.id");
            $sth->execute();

            my $h           = $sth->fetchrow_hashref();
            my $did         = $h->{'dealer_id'};
            my $uid         = $h->{'id'};
            my $username    = $h->{'username'};
            my $buyer_email = $h->{'email'};
            my $buyer_name  = $h->{'first_name'} . ' ' . $h->{'last_name'};
            my $buyer_phone = $h->{'phone'};
            my $buyer_address=$h->{'address1'} . ' ' . $href->{'address2'};
            my $buyer_city  = $h->{'city'};
            my $buyer_state = $h->{'state'};
            my $buyer_zip   = $h->{'zip'};
            $sth->finish();

          # Charge the buyer the appropriate fee.
            my $percentage;

            $sth = $dbh->prepare("SELECT percentage FROM fees WHERE " .
              "low<='$amount' AND high>='$amount'");
            $sth->execute();

            if ($h = $sth->fetchrow_hashref()) {
                $percentage = $h->{'percentage'};
            } else {
                $percentage = 1;
            }

            $sth->finish();
            my $fee = sprintf("%.2f", ($amount * $percentage) / 100);
            $fee = CommaFormatted($fee);

            $dbh->do("INSERT INTO charges SET auction_id='$id', " .
              "dealer_id='$did', user_id='$uid', vehicle_id='$vid', " .
              "fee='$fee', fee_type='buy', modified=NOW(), " .
              "created=modified, status='open'");
              
   
          $sth = $dbh->prepare("SELECT aes.user_id as aeuid, aes.commission_percentage, " . 
              "dms.user_id as dmuid, dms.override_percentage FROM aes, dms, dealers " . 
              "WHERE dealers.id='$did' AND dealers.ae_id=aes.id AND aes.dm_id=dms.id");
          $sth->execute();
              
          my $hb          = $sth->fetchrow_hashref();
          my $ae_user_id  = $hb->{'aeuid'};
          my $ae_com      = $hb->{'commission_percentage'};
          my $dm_user_id  = $hb->{'dmuid'};
          my $dm_ovr      = $hb->{'override_percentage'};
          $sth->finish();
          
          my $commission = 0;
          my $override = 0;
        	$commission = $fee * $ae_com;
        	if ($dm_user_id != $ae_user_id) {
        		$override = $dm_ovr * $commission;
        	}
        	
        	$sth = $dbh->prepare("INSERT INTO commission SET type_id='$id', ae_user_id='$ae_user_id', " . 
          "commission='$commission', dm_user_id='$dm_user_id', override='$override', " . 
          "fee_type='buy', dealer_type='buyer', modified=NOW(), created=NOW()");
          $sth->execute();


          # Send a message to the seller.
            my $msg = "UserID: $seller_uname
Full Name: $seller_name

Congratulations, a winning bid has been accepted for the following auction:

Auction \#:            $id
Auction Title:        $title
Start Time:           $starts
End Time:             $ends
Stock Number:         $stock_num
VIN/HIN:              $vin $hin
Winning Bid Amount US \$$amount_num.

Please contact the buyer within the next 24 hours to coordinate payment for
and transfer item.

Buyer\'s Contact Information:

Name:     $buyer_name
Phone:    $buyer_phone
E-mail:   $buyer_email
Address:  $buyer_address
Location: $buyer_city, $buyer_state $buyer_zip
";

            if ($has_sell_fee) {
                $dbh->do("INSERT INTO charges SET auction_id='$id', " .
                  "dealer_id='$dealer_id', user_id='$seller_id', " .
                  "vehicle_id='$vid', fee='$fee', fee_type='sell', " .
                  "modified=NOW(), created=modified, status='open'");
                  
          $sth = $dbh->prepare("SELECT aes.user_id as aeuid, aes.commission_percentage, " . 
              "dms.user_id as dmuid, dms.override_percentage FROM aes, dms, dealers " . 
              "WHERE dealers.id='$dealer_id' AND dealers.ae_id=aes.id AND aes.dm_id=dms.id");
          $sth->execute();
              
          my $hs          = $sth->fetchrow_hashref();
          my $ae_user_id  = $hs->{'aeuid'};
          my $ae_com      = $hs->{'commission_percentage'};
          my $dm_user_id  = $hs->{'dmuid'};
          my $dm_ovr      = $hs->{'override_percentage'};
          $sth->finish();
          
          my $commission = 0;
          my $override = 0;
        	$commission = $fee * $ae_com;
        	if ($dm_user_id != $ae_user_id) {
        		$override = $dm_ovr * $commission;
        	}
        	
        	$sth = $dbh->prepare("INSERT INTO commission SET type_id='$id', ae_user_id='$ae_user_id', " . 
          "commission='$commission', dm_user_id='$dm_user_id', override='$override', " . 
          "fee_type='sell', dealer_type='seller', modified=NOW(), created=NOW()");
          $sth->execute();

                $msg .= "
Your sell fee due to Go DEALER to DEALER is US \$$fee.
This fee will be added to your account and automatically processed at the end 
of the month.

";
            }
            else {
            
                $sth = $dbh->prepare("SELECT aes.user_id as aeuid, aes.commission_percentage, " . 
                  "dms.user_id as dmuid, dms.override_percentage FROM aes, dms, dealers " . 
                  "WHERE dealers.id='$dealer_id' AND dealers.ae_id=aes.id AND aes.dm_id=dms.id");
                $sth->execute();
                    
                my $hs          = $sth->fetchrow_hashref();
                my $ae_user_id  = $hs->{'aeuid'};
                my $ae_com      = $hs->{'commission_percentage'};
                my $dm_user_id  = $hs->{'dmuid'};
                my $dm_ovr      = $hs->{'override_percentage'};
                $sth->finish();
                
                my $commission = 0;
                my $override = 0;
              	$commission = $fee * $ae_com;
              	if ($dm_user_id != $ae_user_id) {
              		$override = $dm_ovr * $commission;
              	}
              	
              	$sth = $dbh->prepare("INSERT INTO commission SET type_id='$id', ae_user_id='$ae_user_id', " . 
                "commission='$commission', dm_user_id='$dm_user_id', override='$override', " . 
                "fee_type='buy', dealer_type='seller', modified=NOW(), created=NOW()");
                $sth->execute();
          
            }
            

            $msg .= "
Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";

            sendMail($email_from, $seller_email,
              "Auction #$id closed with a sale", $msg);

          # Send a message to the buyer.
            $msg = "UserID: $username
Full Name: $buyer_name

Congratulations, you have the winning bid for the following auction:

Auction \#:            $id
Auction Title:        $title
Start Time:           $starts
End Time:             $ends
VIN/HIN:              $vin $hin
Winning Bid Price US \$$amount_num.

Please contact the seller within the next 24 hours to coordinate payment for
and transfer of the item.

Name:     $seller_name
Phone:    $seller_phone
E-mail:   $seller_email
Address:  $seller_address
Location: $seller_city, $seller_state $seller_zip

Your buy fee due to Go DEALER to DEALER is US \$$fee.
This fee will be added to your account and automatically processed at the end 
of the month.

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER";

            sendMail($email_from, $buyer_email, "You won auction #$id", $msg);

          # Mark the vehicle as being sold.
            $dbh->do("UPDATE vehicles SET status='inactive', sell_price='$amount' " .
              "WHERE id='$vid'");

          # Cha-ching!
            $dbh->do("UPDATE auctions SET chaching='1' WHERE id='$id'");
        } else {
            my $msg = "UserID: $seller_uname
Full Name: $seller_name

The following auction closed without meeting the reserve price:

Auction \#:        $id
Auction Title:    $title
Start Time:       $starts
End Time:         $ends
Stock Number:     $stock_num
VIN/HIN:          $vin $hin
Bids Start at: US \$$minimum_bid_num
Reserve Price: US \$$reserve_price_num
Buy Now Price: US \$$buy_now_price_num
High Bid:      US \$$amount_num


To Re-List this auction, go to this URL:
http://test.godealertodealer.com/auction/auctions/add.php?vid=$vid

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank You,

Go DEALER to DEALER
";

            if ($amount > 0) {
                $msg .= "\nThe last bid was US \$$amount_num.";
            }

            sendMail($email_from, $seller_email,
              "Auction #$id closed without a sale.", $msg);
              
          if ($winning_bid > '0') {
            # Determine the highest bidder's user ID.
            $sth = $dbh->prepare("SELECT users.id FROM bids, users " . 
              "WHERE bids.id='$winning_bid' AND bids.user_id=users.id");
            $sth->execute();

            my $h           = $sth->fetchrow_hashref();
            my $uid         = $h->{'id'};
            $sth->finish();
            
            #Send an alert to the buyer
            $dbh->do("INSERT INTO alerts SET auction_id='$id', vehicle_id='$vid', " .
              "to_user='$uid', final_bid='$amount', reserve_price='$reserve_price', " .
              "modified=NOW() ");
            
            #Send an alert to the seller
            $dbh->do("INSERT INTO alerts SET auction_id='$id', vehicle_id='$vid', " .
              "to_user='$seller_id', final_bid='$amount', reserve_price='$reserve_price', " .
              "modified=NOW() ");    
          }
        }
    }
    

# Now get a list the emails that need to go out for the Watch List.
    $sth = $dbh->prepare("SELECT watch_list.id as wid, auctions.id, auctions.title, auctions.current_bid, " .
            "DATE_FORMAT(auctions.ends, '%W, %M %D, %Y at %l:%m%p') as ends, auctions.views, users.username, users.email, users.first_name, " . 
            "users.last_name FROM watch_list, auctions, users WHERE watch_list.user_id=users.id " .
            "AND watch_list.reminder<=NOW() AND watch_list.email='pending'" . 
            "AND watch_list.auction_id=auctions.id ORDER BY watch_list.id ASC");
    $sth->execute();

  # store the list to an hash.
    my %watch = ();
    while (my $href = $sth->fetchrow_hashref()) {
        my $new = $href->{'wid'};

        $watch{$new} = $href;
    }

    $sth->finish();

  # Send Email.
    foreach my $new (keys %watch) {
        my $href          = $watch{$new};
        
        my $wid = $href->{'wid'};
        
        my $aid = $href->{'id'};
        my $atitle = $href->{'title'};
        my $acur_bid = $href->{'current_bid'};
        my $aends = $href->{'ends'};
        my $aviews = $href->{'views'};
        
        my $uname = $href->{'username'};
        my $uemail = $href->{'email'}; 
        my $ufullname   = $href->{'first_name'} . ' ' . $href->{'last_name'};
        
        my $msg = "Username: $uname
Full Name:  $ufullname

This email alert is to notify you that an auction in your Watch List is about 
to close. 

Below are the details of your Watched item:

Auction \#$aid
Auction Title:   $atitle
Current bid:     US \$$acur_bid
Number of Views: $aviews
Auction Close:   $aends

Click here to review this auction.

http://test.godealertodealer.com/auction/auction.php?id=$aid

Do not reply to this automated message.  This is not a monitored e-mail
account.

Thank you!

Go DEALER to DEALER";

    sendMail($email_from, $uemail, "Watch List Alert for Auction #$aid", $msg);

}

# Update Table to show that an email has been sent.
    $dbh->do("UPDATE watch_list SET email='sent' WHERE reminder<=NOW() AND email='pending'");
    
  # Update Table to show that an auction can no longer be rated.
    $dbh->do("UPDATE ratings SET status='closed' WHERE modified>=endtime OR total>='21'"); 
    
  # Close connection to the database.
    $dbh->disconnect();

  # Remove the lock.
    flock(FH, LOCK_UN);
    unlink($lockfile);
}
