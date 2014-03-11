%progol, polymath
:- set(i,2), set(h,20), set(c,2)?

:-modeh(*,learns(+person, +subject))?
:-modeh(*,learns(#person, +subject))?

%:-determination(woman/1, female/1)?
%:-determination(woman/1, male/1)?

%type information
person(X).
subject(X).

%background
male(adam).
male(bob).
female(alice).
female(mary).

%positive examples
learns(polymath, mathematics).
learns(polymath, physics).
learns(polymath, chemistry).
learns(jack, mathematics).
learns(susan, physics).

%negative examples
:- learns(jack, physics).
:- learns(susan, chemistry).

