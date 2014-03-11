%toplog, polymath

:-modeh(learns(+person, +subject)).
:-modeh(learns(#person, +subject)).


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

