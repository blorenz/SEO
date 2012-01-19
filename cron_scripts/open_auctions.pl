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
# $srp: godealertodealer.com/cgi-bin/open_auctions.pl,v 1.5 2004/04/19 16:16:06 steve Exp $
#

use DBI;
use Fcntl qw(:DEFAULT :flock);
use Time::Local;
use strict;

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
		$dbh->do("LOCK TABLES auctions WRITE, bids WRITE, vehicles WRITE, photos WRITE");

  # Activate new auctions.
    $dbh->do("UPDATE auctions SET status='open' WHERE starts < NOW() AND " .
      "status='pending'");
			
	# Check to see if any auctions need to be removed because of old age
    my $sth = $dbh->prepare("SELECT auctions.id AS aid, " .
			 			"auctions.status AS auction_status, " .
						"auctions.ends, vehicles.id AS vid, " .
						"vehicles.status AS vehicle_status " .
						"FROM auctions, vehicles " .
						"WHERE auctions.status =  'closed' AND vehicles.id = auctions.vehicle_id" );
    $sth->execute();
		
		# Number of seconds in each day
		# Lets purge every auction older than 60 days.
		my $days = 60;
		my $day = 24 * 60 * 60;
		
    my %auctions = ();
    while (my $href = $sth->fetchrow_hashref()) {
        my $id = $href->{'aid'};

        $auctions{$id} = $href;
    }
		my $count = 0;
    $sth->finish();
		# Now go back and figure out the outcome of each auction.
    foreach my $id (keys %auctions) {
        my $href          	= $auctions{$id};
        my $aid        			= $href->{'aid'};
        my $auction_status  = $href->{'auction_status'};
        my $ends            = $href->{'ends'};
        my $vid							= $href->{'vid'};
        my $vehicle_status  = $href->{'vehicle_status'};

				# if the auction is older than days old
				my ($mday,$mon,$year) = (localtime(time()))[3,4,5];
				my $today = timelocal(0,0,12,$mday,$mon,$year);

#rewerite $ends to be proper input for the $days_since calculation below RPH/JJM 5/21/2011
   if ( $ends eq "0000-00-00 00:00:00" )
       { $ends = $today; }
   else
       { $ends = timelocal(substr($ends,17,2),substr($ends,14,2),substr($ends,11,2),substr($ends,8,2),substr($ends,5,2)-1,substr($ends,0,4)); }

				my $days_since = int($today - $ends)/$day;
			
        if (($days_since > $days) && ($vehicle_status eq "sold")) {
				
					 $count=$count+1;

					 my $sth1 = $dbh->prepare("DELETE FROM bids WHERE auction_id='$aid'");
					 $sth1->execute();
					 $sth1->finish();
					 
					 my $sth = $dbh->prepare("SELECT id FROM photos WHERE vehicle_id='$vid'");
    			 $sth->execute();
		
    			 while (my $href = $sth->fetchrow_hashref()) {
        				my $pid = $href->{'id'};

        				if ( -e "../htdocs/auction/uploaded/'$pid'.jpg")
					 			{
		 	 		 					 unlink ("../htdocs/auction/uploaded/'$pid'.jpg"); 
					 			}
    			 }
    			 $sth->finish();
					 
					 my $sth2 = $dbh->prepare("DELETE FROM photos WHERE vehicle_id='$vid'");
					 $sth2->execute();
					 $sth2->finish();

					 my $sth3 = $dbh->prepare("DELETE FROM auctions WHERE id='$aid'");
					 $sth3->execute();
					 $sth3->finish();
					 
					 my $sth4 = $dbh->prepare("DELETE FROM vehicles WHERE id='$vid'");
					 $sth4->execute();
					 $sth4->finish();
				}
		}
  # Unlock tables.
    $dbh->do("UNLOCK TABLES");

  # Close connection to the database.
    $dbh->disconnect();

  # Remove the lock.
    flock(FH, LOCK_UN);
    unlink($lockfile);
		
		exit;
}
