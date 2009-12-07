#!/usr/bin/perl
#
# scan list-strings...
#
use warnings;
use strict;

my $show_linenumbers=0;

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
				foreach my $line  (<FH>) {
				    $line_num++;
					while((my $key,my $rest) = $line =~ 
					        /\b
					        __
					        \(
					        [\"\']
					        (
					         .*?
					        )
					        [\"\']
					        \)
					        (.*)
					        /gx
					    ) {
					    $key =~ s/",\s*"/|/; 
					    $key =~ s/',\s*'/|/; 
						unless($flag_headline_shown) {
							print "\n\n$f\n";
							$flag_headline_shown= 1;
						}
						print "key='$key'\n";
						unless($all_language_keys{$key}) {
    						push(@all_language_keys_list, "$key|$f  Line $line_num");
                        }
						$all_language_keys{$key}="$f  Line $line_num";

						$line= $rest;
					}
				}
			}
		}
	}
}

sub scan_language_defs {
    print "\n\nScanning language-definition files...\n";
  
    my %language_keys;
    my @language_keys_list;
    my %undefined_keys;
    my %obsolete_keys;

    foreach my $f (glob("./*.inc.php")) {
        print "$f\n";
        my $flag_found_changes=0;
        %language_keys= ();
        %undefined_keys=();
        %obsolete_keys =();
        
        open FH, $f or die "Could not open $f";

        ### scan defined footage of language-file ###
        my $text= join("",<FH>);
        while($text) {
            if( (my $key, my $value, my $rest) = $text =~/
                [\'\"]{1}
                ([^\'\"]*)
                [\'\"]{1}
                \s*
                =>
                \s*
                [\'\"]{1}
                ([^\'\"]*)
                [\'\"]{1}
                \s*
                ,
                \s*
                (.*)
                /sxg) {
                print "key=$key value=$value\n";
                $language_keys{$key}= $value;                                   # keep all keys
                push @language_keys_list, $value;

                ### if not used in any source-file, keep as obsolete ###
                unless($all_language_keys{$key}) {                                  
                    $obsolete_keys{$key}=1
                }
                $text= $rest;
            }
            elsif( $text =~ /^[^\n].*\n(.*)/) {
                $text= $rest;
            }
            else {
                last;
            }
        }

        my $buffer_changes="";

        ### list undefined keys ###
        my $key;
        my $value;
        my $flag_found=0;
        my $last_file="";
        foreach my $str (@all_language_keys_list) {
            (my $key, my $hint) = $str =~ /(.*)\|(.*)/;
            unless($key) {
                next;
            }
            
            unless($language_keys{$key}) {
                unless($all_language_keys{$key}) {
                    next;
                }
                #print "undefined key=$key defined in $all_language_keys{$key}\n";
                unless($flag_found) {
                    $buffer_changes.="undefined keys:\n";
                    $buffer_changes.="---------------\n";
                    $flag_found= 1;
                }
                if((my $tmp_file, my $line)= $all_language_keys{$key}=~ /(.*)Line (.*)/) {
                    if($tmp_file ne $last_file) {
                        #$buffer_changes.="\n### $tmp_file ###\n";
                        $last_file= $tmp_file;
                    }
                    my $num_spaces= 28 - length($key);
                    if($num_spaces < 0){
                        $num_spaces=0;
                    }
                    my $spaces= " " x $num_spaces;
                    $buffer_changes.= "'$key'$spaces=>'',";
                    if($show_linenumbers) {
                        $buffer_changes.="  # line $line\n";
                    }
                    else {
                        $buffer_changes.="\n";
                    }
                }
            }
        }
        open FH_OUT,">$f.changes" or die "could not create $f.changes";
        print FH_OUT $buffer_changes;
        close FH_OUT;
        
    }
}