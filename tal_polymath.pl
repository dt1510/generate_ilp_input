%tal, polymath
:- multifile option/2.
option(max_body_literals, 2).
option(score_before_condition, false).
option(max_num_rules, 2).
option(single_seed, false).
option(strategy, full_breadth).
option(max_depth, 200).
:-dynamic learns/2.

modeh(learns(+person, +subject)).
modeh(learns(#person, +subject)).


%type information
person(X).
subject(X).

%background
male(adam).
male(bob).
female(alice).
female(mary).

%positive examples
example(learns(polymath, mathematics),1).
example(learns(polymath, physics),1).
example(learns(polymath, chemistry),1).
example(learns(jack, mathematics),1).
example(learns(susan, physics),1).

%negative examples
:- learns(jack, physics).
:- learns(susan, chemistry).

