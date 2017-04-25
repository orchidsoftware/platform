#!/bin/bash

# This script reads the total amount of bytes transfered
# and received through the interface defined by INTERFACE
# below.
#
# The script then pauses for a second before reading the
# total Tx and Rx bytes again.
#
# Subtracting these two values then gives the current
# Tx and Rx bytes per second.

INTERFACE=eth0

P1_rx=`cat /sys/class/net/${INTERFACE}/statistics/rx_bytes`
P1_tx=`cat /sys/class/net/${INTERFACE}/statistics/tx_bytes`
sleep 1;
P2_rx=`cat /sys/class/net/${INTERFACE}/statistics/rx_bytes`
P2_tx=`cat /sys/class/net/${INTERFACE}/statistics/tx_bytes`
echo `expr  ${P2_rx} - ${P1_rx}` `expr  ${P2_tx} - ${P1_tx}`
