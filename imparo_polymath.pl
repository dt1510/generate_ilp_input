%imparo, polymath
head_modes([learns(+person, +subject),learns(#person, +subject)]).
body_modes([]).
%type information
person(X).
subject(X).

%file%imb
%background
male(adam).
male(bob).
female(alice).
female(mary).

%file%imx
%positive examples
learns(polymath, mathematics).
learns(polymath, physics).
learns(polymath, chemistry).
learns(jack, mathematics).
learns(susan, physics).

%negative examples
:- learns(jack, physics).
:- learns(susan, chemistry).

