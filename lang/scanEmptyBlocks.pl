#
# scan list-strings...
#
use warnings;
use strict;

my $show_linenumbers=1;

my %all_language_keys={};               # keep track of defined keys
my @all_language_keys_list=[];           # keep list in correct order

scan_dir("../*");
scan_language_defs();

sub scan_dir {
	my $dir= shift;
	if($dir =~ /\/lang\//) {
	    next;
	}

	foreach my $f (glob("$dir/*")) {
		if($f ne $dir && -d $f) {
			scan_dir($f);
		}
		else {
			if ($f =~ /\.(inc|php)$/) {
				my $flag_headline_shown= 0;
				#print "$f\n";

				### scan files ###
				open FH,$f or die "Could not open $f";
				my $line_num=0;
				my $combined="";
				foreach my $line  (<FH>) {
				    if($line =~ /(.*)#/) {
				        $line=$1;
				    }
				    $combined .= $line;
				}
				if($combined =~ /\{\s*\}(.{0,100})/s) {
				    print "\nfound block in $f\n---------------------\n near $1\n";
				}
			}
		}
	}
}

