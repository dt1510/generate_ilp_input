%tal, test
:- multifile option/2.
option(max_body_literals, 2).
option(score_before_condition, false).
option(max_num_rules, 2).
option(single_seed, false).
option(strategy, full_breadth).
option(max_depth, 200).
:-dynamic woman/1, female/1, male/1.

modeh(woman(+person)).
modeb(female(+person)).
modeb(male(+person)).


%type information
person(adam).
person(bob).
person(alice).
person(mary).

%background knowledge
male(adam).
male(bob).
female(alice).
female(mary).
female(susan).

%positive examples
example(woman(alice),1).
example(woman(mary),1).
example(woman(susan),1).

%negative examples
example(woman(adam),-1).

